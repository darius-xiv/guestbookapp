<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FilipayUsers;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('login_auth')) {
            $user_list = FilipayUsers::all();

            return view('dashboard', ['user_list' => $user_list]);
        } else {
            return redirect('login');
        }
    }

    public function signOut()
    {
        session()->flush('login_auth');
        return redirect('login');
    }

    public function editUser(Request $request)
    {
        $id_exist_filipay_users = DB::table('filipay_users AS fu')
            ->select('fu.*', 'ci.mobile_no', 'ci.landline', 'ci.address')
            ->leftJoin('contact_information AS ci', 'fu.id', '=', 'ci.user_id')
            ->where('fu.id', request('id'));

        if ($id_exist_filipay_users) {
            $get_details = $id_exist_filipay_users->first();
            $data = array(
                'id' => $get_details->id,
                'first_name' => $get_details->first_name,
                'last_name' => $get_details->last_name,
                'gender' => $get_details->gender,
                'b_day' => $get_details->b_day,
                'mobile_no' => $get_details->mobile_no,
                'landline' => $get_details->landline,
                'address' => $get_details->address
            );

            return view('edit_page', $data);
        } else {
            return "No data found.";
        }
    }

    public function editUserScript(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'b_day' => 'required|before:tomorrow',
            'gender' => 'required',
            'mobile_no' => 'required',
            'landline' => 'required',
            'address' => 'required'
        ]);

        FilipayUsers::where('id', request('id'))->update([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'b_day' => request('b_day'),
            'gender' => request('gender')
        ]);

        if (DB::table('contact_information')->where('user_id', request('id'))->exists()) {
            DB::table('contact_information')
                ->where('user_id', request('id'))
                ->update([
                    'mobile_no' => request('mobile_no'),
                    'landline' => request('landline'),
                    'address' => request('address')
                ]);
        } else {
            DB::table('contact_information')->insert(
                [
                    'mobile_no' => request('mobile_no'),
                    'landline' => request('landline'),
                    'address' => request('address'),
                    'user_id' => request('id')
                ]
            );
        }

        session()->flash('edit_success', 'You have successfully edit an account.'); // Testing flash sessions
        return redirect('/dashboard');
    }

    public function deleteUser(Request $request)
    {
        $id_exist = FilipayUsers::where('id', request('id'));

        if ($id_exist->exists()) {
            $data['id'] = request('id');
            return view('delete_page', $data);
        } else {
            return "No data found.";
        }
    }

    public function deleteUserScript(Request $request)
    {
        if (request('id')) {
            $id_exist = FilipayUsers::findOrFail(request('id'));
            $id_exist->delete();
            session()->flash('edit_success', 'You have successfully deleted an account.'); // Testing flash sessions
        } else {
            session()->flash('edit_errors', 'Something went wrong.'); // Testing flash sessions
        }
        return redirect('/dashboard');
    }

    public function previewUser(Request $request)
    {
        $id_exist_filipay_users = DB::table('filipay_users AS fu')
            ->select('fu.*', 'ci.mobile_no', 'ci.landline', 'ci.address')
            ->leftJoin('contact_information AS ci', 'fu.id', '=', 'ci.user_id')
            ->where('fu.id', request('id'));

        if ($id_exist_filipay_users) {
            $get_details = $id_exist_filipay_users->first();
            $data = array(
                'id' => $get_details->id,
                'name' => $get_details->first_name . " " . $get_details->last_name,
                'gender' => $get_details->gender,
                'b_day' => date("F j, Y", strtotime($get_details->b_day)),
                'mobile_no' => ($get_details->mobile_no) ? ($get_details->mobile_no) : "N/A",
                'landline' => ($get_details->landline) ? ($get_details->landline) : "N/A",
                'address' => ($get_details->address) ? ($get_details->address) : "N/A",
                'picture' => $get_details->profile_picture_path
            );

            return view('view_user', $data);
        } else {
            return "No data found.";
        }
    }

    public function uploadPicture(Request $request)
    {
        if (request('id')) {
            $data['id'] = request('id');
            return view('upload_picture', $data);
        } else {
            return "Unavailable to upload profile.";
        }
    }
    public function uploadPictureScript(Request $request)
    {
        $this->validate($request, [
            'input_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('input_img')) {
            $image = $request->file('input_img');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            DB::table('filipay_users')
                ->where('id', request('id'))
                ->update([
                    'profile_picture_path' => $name,
                ]);

            session(['profile_picture_path' => $name]);

            session()->flash('edit_success', 'You have successfully update profile picture.'); // Testing flash sessions
            return redirect('/dashboard');
        }
    }

    public function searchEmployee()
    {
        $fetch_user_list = DB::table('filipay_users')
            ->select('*')
            ->where([
                ['first_name', 'like', '%' . request('keyword') . '%'],
                ['gender', 'like', request('gender') . '%']
            ])
            // ->where('first_name', 'like', '%' . request('keyword') . '%')
            // ->orWhere('last_name', 'like', '%' . request('keyword') . '%')
            // ->where('gender', 'like', '%' . request('gender') . '%')
            ->orderBy('b_day', request('b_day'))
            ->get();

        if ($fetch_user_list && count($fetch_user_list) > 0) {
            foreach ($fetch_user_list as $row) {
                $user_list[] = array(
                    'id' => $row->id,
                    'first_name' => $row->first_name,
                    'last_name' => $row->last_name,
                    'profile_picture_path' => $row->profile_picture_path,
                    'username' => $row->username,
                    'b_day' => $row->b_day,
                    'gender' => $row->gender
                )
                ;
            }
            return view('dashboard_table', ['user_list' => $user_list]);
        } else {
            return ("No data was found");
        }
    }

}
