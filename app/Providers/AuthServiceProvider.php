<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email Radar Banjarmasin Iklan')
                ->greeting('Terimakasih telah mendaftar!')
                ->line('Tekan tombol dibawah ini untuk memverifikasi email anda.')
                ->action('Verifikasi Email Anda', $url)
                ->line('Jika anda merasa tidak pernah membuat akun, harap ABAIKAN pesan ini.')
                ->line('Dengan Hormat,')
                ->salutation('Radar Banjarmasin');
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $url) {
            $expiration = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

            return (new MailMessage)
                ->subject('Reset Password Radar Banjarmasin Iklan')
                ->greeting('Terimakasih telah mengkonfirmasi!')
                ->line('Anda menerima email ini karena kami menerima permintaan reset password dari akun anda.')
                ->action('Reset Password', $url)
                ->line('Jika Anda tidak meminta reset password, harap ABAIKAN pesan ini.')
                ->line('Tautan reset password akan kadaluwarsa dalam ' . $expiration . ' menit.')
                ->line('Dengan Hormat,')
                ->salutation('Radar Banjarmasin');
        });
    }
}
