<?php
 
namespace App\Http\Controllers;

use Socialite;
use Auth;
use Redirect;
use Session;
use URL;
use File;
use App\Libraries\Helpers;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;

class FacebookAuthController extends Controller
{
    public function redirectToProvider()
    {
        if (!Session::has('pre_url')) {
            Session::put('pre_url', URL::previous());
        } else {
            if (URL::previous() != URL::to('login')) {
                Session::put('pre_url', URL::previous());
            }
        }
        return Socialite::driver('facebook')->redirect();
    }
 
    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        if($user->email=='')
            $user->email = changeTitle(trim($user->name)).'@gmail.com';

        // dd($user->getAvatar());
        $authUser = $this->findOrCreateUser($user);
        
        // Chỗ này để check xem nó có chạy hay không
        // dd($user);

        Auth::login($authUser);
        
        // Auth::login($authUser, true);
 
        return redirect()->route('index');
    }
 
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('provider_id', $facebookUser->id)->first();
        if ($authUser) {
            return $authUser;
        }
        if ($facebookUser->email != '') {
            $email = $facebookUser->email;
        } else {
            $email = $facebookUser->id.'@gmail.com';
        }
        $username = str_replace(' ', '', Helpers::remove_accents($facebookUser->name));
        $username = strtolower($username.rand(0, 10000));
        $check_email = User::where('email', $email)->first();
        if ($check_email) {
            return $check_email;
            /*$msg = "Email Facebook đã được sử dụng để đăng ký tài khoản";
            $result = "";
            $result .= "<script language='javascript'>alert('".$msg."');</script>";
            $result .= "<script language='javascript'>history.go(-1);</script>";
            echo $result;
            exit();*/
        } else {
            $datetime_now=date('Y-m-d H:i:s');
            $datetime_convert=strtotime($datetime_now);
            $avatar = file_get_contents($facebookUser->getAvatar());
            // dd($avatar);
            $name_avatar = "avatar-".$datetime_convert.'-'.$facebookUser->getId().".jpg";
            $image_resize = Image::make($avatar);
            $image_resize->resize(null, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save(public_path('img/users/avatar/'.$name_avatar));
            // File::put('/images/avatar/' ."avatar-".$datetime_convert.'-'.$facebookUser->getId().".jpg", $avatar);
            
            $result = User::create([
                'name' => $facebookUser->name,
                'password' => bcrypt($facebookUser->token),
                'username' => $username,
                'avatar' => $name_avatar,
                'email' => $email,
                'provider_id' => $facebookUser->id,
                'provider' => $facebookUser->id,
            ]);
            return $result;
        }
    }
}
