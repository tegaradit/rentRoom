<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterGuard
{
    private $roleId = [
        'admin' => 1, 
        'siswa' => 2,
        'guru' => 3
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = auth();
        if (!$auth->check()) {
            if (!$request->is('/')) {
                return redirect('/');
            }
            return $next($request);
        }
        $user = $auth->user();
        if ($request->path() === '/') {
            return Response(['hitted']);
            if ($user->role_id == $this->roleId['admin']) {
                return redirect()->intended('admin/')->with('username', $user->nama_lengkap);
            } else if ($user->role_id == $this->roleId['guru']) {
                return redirect()->intended('user/')->with('username', $user->nama_lengkap);
            } else {
                return redirect()->intended('user/')->with('username', $user->nama_lengkap);
            }
        }

        if ($user->role_id == $this->roleId['guru'] && strpos($request->path(), 'user') === false) {
            return redirect()->intended('user/')->with('username', $user->nama_lengkap);
        } else if ($user->role_id == $this->roleId['siswa'] && strpos($request->path(), 'user') === false) {
            return redirect()->intended('user/')->with('username', $user->nama_lengkap);
        }
        return $next($request);
    }
}
