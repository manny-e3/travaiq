<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordSubmitRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

 

    public function showForgetPasswordForm()
    {
        return view('auth.resetPassword');
    }

    public function loginPost(LoginRequest $request)
    {
        //  return "here";
        $loginResponse = $this->authService->login($request->only('email', 'password'));

        if (!$loginResponse['status']) {
            return redirect()->back()->with('error', $loginResponse['error']);
        }

        // Check if there's a trip detail from saved temporary plan
        $tripDetail = $loginResponse['tripDetail'] ?? null;
        
        if ($tripDetail) {
            return redirect()->route('trips.show', $tripDetail->location_overview_id)
                ->with('success', 'Your travel plan has been saved to your account!')
                ->with('tripDetails', $tripDetail);
        }

        return redirect('/')->with('success', 'Login successful!');
    }

    /**
     * Handle forgot password request.
     */
    public function userForgetpassword(ForgetPasswordRequest $request)
    {

         $success = $this->authService->forgetPassword($request->email);

        if (! $success) {
            return back()->with('error', 'Email not found.');
        }

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    /**
     * Show reset password view.
     */
    public function resetpassword($token)
    {
        $data = $this->authService->getResetPasswordView($token);

        if (! $data) {
            return redirect()->route('loginRegister')->with('error', 'Invalid password reset token.');
        }

        return view('auth.passwords.reset', $data);
    }

    /**
     * Handle password reset submission.
     */
    public function resetpasswordsubmit(ResetPasswordSubmitRequest $request)
    {
       ;
        $result = $this->authService->resetPasswordSubmit($request->validated());

        if ($result !== true) {
            return back()->withInput()->with('error', $result);
        }

        return redirect('login-register')->with('success', 'Your password has been changed!');
    }

    
    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function showLoginRegisterForm()
    {
        return view('auth.login_register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

         $registerResponse = $this->authService->register($request->only('name', 'email','password'));
        
        if (!$registerResponse['status']) {
            return back()->withInput()->with('error', 'Registration failed.');
        }

        // Check if there's a trip detail from saved temporary plan
         $tripDetail = $registerResponse['tripDetail'] ?? null;
        
        if ($tripDetail) {
            return redirect()->route('trips.show', $tripDetail->location_overview_id)
                ->with('success', 'Your travel plan has been saved to your account!')
                ->with('tripDetails', $tripDetail);
        }else{
            // If no trip detail, just redirect to home with success message
            return redirect('/')->with('success', 'Registration successful!');
        }
        
        
      
    }
}
