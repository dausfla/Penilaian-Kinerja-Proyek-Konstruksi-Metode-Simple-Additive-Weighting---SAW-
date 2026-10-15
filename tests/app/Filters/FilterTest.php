<?php

namespace Tests\App\Filters;

use App\Filters\AdminFilter;
use App\Filters\AuthFilter;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\CIUnitTestCase;
use Config\App;

/**
 * @internal
 */
final class FilterTest extends CIUnitTestCase
{
    private function createRequest(): IncomingRequest
    {
        $config = new App();
        $uri = new URI('http://localhost:8080/dashboard');
        return new IncomingRequest($config, $uri, null, new UserAgent());
    }

    public function testAuthFilterRedirectsWhenNotLoggedIn(): void
    {
        // Ensure session is cleared
        session()->destroy();

        $filter = new AuthFilter();
        $request = $this->createRequest();

        $result = $filter->before($request);

        // When unauthenticated, before() returns a RedirectResponse
        $this->assertNotNull($result, 'AuthFilter should return a redirect response when user is not logged in.');
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $result);
    }

    public function testAuthFilterAllowsWhenLoggedIn(): void
    {
        session()->set([
            'is_logged_in' => true,
            'user_id'      => 1,
            'user_nama'    => 'Administrator',
            'user_role'    => 'admin',
        ]);

        $filter = new AuthFilter();
        $request = $this->createRequest();

        $result = $filter->before($request);

        // When authenticated, before() returns null to continue execution
        $this->assertNull($result, 'AuthFilter should allow access when user is logged in.');
    }

    public function testAdminFilterBlocksNonAdminUser(): void
    {
        session()->set([
            'is_logged_in' => true,
            'user_id'      => 2,
            'user_nama'    => 'Direksi',
            'user_role'    => 'manajemen',
        ]);

        $filter = new AdminFilter();
        $request = $this->createRequest();

        $result = $filter->before($request);

        // Manajemen role should be blocked and redirected
        $this->assertNotNull($result, 'AdminFilter should redirect non-admin user.');
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $result);
    }

    public function testAdminFilterAllowsAdminUser(): void
    {
        session()->set([
            'is_logged_in' => true,
            'user_id'      => 1,
            'user_nama'    => 'Administrator',
            'user_role'    => 'admin',
        ]);

        $filter = new AdminFilter();
        $request = $this->createRequest();

        $result = $filter->before($request);

        // Admin role should be allowed
        $this->assertNull($result, 'AdminFilter should allow admin user.');
    }
}
