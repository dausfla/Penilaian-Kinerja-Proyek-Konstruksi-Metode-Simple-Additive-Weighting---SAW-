<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (! $session->get('is_logged_in')) {
            return redirect()->to(site_url('login'))->with('error', 'Silakan masuk terlebih dahulu.');
        }

        if ($session->get('user_role') !== 'admin') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Akses ditolak: Hanya peran Admin yang dapat melakukan perubahan data.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
