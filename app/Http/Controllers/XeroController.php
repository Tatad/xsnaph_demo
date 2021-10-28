<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webfox\Xero\OauthCredentialManager;
use App\Models\Organizations;
use App\Models\RdoCodes;

class XeroController extends Controller
{

    public function index(Request $request)
    {
        return view('xero', [
            'connected' => '',
            'error'            => $error ?? null,
            'organisationName' => $organisationName ?? null,
            'username'         => $username ?? null
        ]);
    }

    public function success(Request $request, OauthCredentialManager $xeroCredentials)
    {
        try {
            // Check if we've got any stored credentials
            if ($xeroCredentials->exists()) {
                /* 
                 * We have stored credentials so we can resolve the AccountingApi, 
                 * If we were sure we already had some stored credentials then we could just resolve this through the controller
                 * But since we use this route for the initial authentication we cannot be sure!
                 */
                $xero             = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
                $xeroIdentity             = resolve(\XeroAPI\XeroPHP\Api\IdentityApi::class);
                // dd();
                // dd($xero->getOrganisations($xeroCredentials->getTenantId()) );
                $organisationName = $xero->getOrganisations($xeroCredentials->getTenantId())->getOrganisations()[0]->getName();
                $user             = $xeroCredentials->getUser();
                $username         = "{$user['given_name']} {$user['family_name']} ({$user['username']})";
                $organizations    = $xeroIdentity->getConnections();
                //dd($xeroIdentity->getConnections());
            }
        } catch (\throwable $e) {
            // This can happen if the credentials have been revoked or there is an error with the organisation (e.g. it's expired)
            $error = $e->getMessage();
        }

        return view('xero-connects', [
            'connected'        => $xeroCredentials->exists(),
            'error'            => $error ?? null,
            'organisationName' => $organisationName ?? null,
            'username'         => $username ?? null,
            'organizations'    => $organizations ?? null
        ]);
    }

    public function deleteOrg(Request $request, OauthCredentialManager $xeroCredentials, $id){
        
        $organizations = [];
        try {
            // Check if we've got any stored credentials
            if ($xeroCredentials->exists()) {
                /* 
                 * We have stored credentials so we can resolve the AccountingApi, 
                 * If we were sure we already had some stored credentials then we could just resolve this through the controller
                 * But since we use this route for the initial authentication we cannot be sure!
                 */
                $xero             = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
                $xeroIdentity             = resolve(\XeroAPI\XeroPHP\Api\IdentityApi::class);

                if($id){
                    $xeroIdentity->deleteConnection($id);
                }

                $organisationName = $xero->getOrganisations($xeroCredentials->getTenantId())->getOrganisations()[0]->getName();
                $user             = $xeroCredentials->getUser();
                $username         = "{$user['given_name']} {$user['family_name']} ({$user['username']})";
                $organizations    = $xeroIdentity->getConnections();
                //dd($xeroIdentity->getConnections());
            }
        } catch (\throwable $e) {
            // This can happen if the credentials have been revoked or there is an error with the organisation (e.g. it's expired)
            $error = $e->getMessage();
        }
        return view('xero-connects', [
            'connected'        => $xeroCredentials->exists(),
            'error'            => $error ?? null,
            'organisationName' => $organisationName ?? null,
            'username'         => $username ?? null,
            'organizations'    => $organizations ?? null
        ]);
    }

    public function selectOrg($id, OauthCredentialManager $xeroCredentials){
        $org = Organizations::where('tenant_id', $id)->first();
        try {
            // Check if we've got any stored credentials
            if ($xeroCredentials->exists()) {
                /* 
                 * We have stored credentials so we can resolve the AccountingApi, 
                 * If we were sure we already had some stored credentials then we could just resolve this through the controller
                 * But since we use this route for the initial authentication we cannot be sure!
                 */
                $xero             = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
                $xeroIdentity             = resolve(\XeroAPI\XeroPHP\Api\IdentityApi::class);

                if($id){
                    $xeroIdentity->getConnections($id);
                }
               
                //dd(collect($xeroIdentity->getConnections()));
                $organisationName = $xero->getOrganisations($id)->getOrganisations()[0]->getName();
                $user             = $xeroCredentials->getUser();
                $username         = "{$user['given_name']} {$user['family_name']} ({$user['username']})";
            }
        } catch (\throwable $e) {
            // This can happen if the credentials have been revoked or there is an error with the organisation (e.g. it's expired)
            $error = $e->getMessage();
        }

        //dd($organisationName);
        if(collect($org)->isEmpty()){
            $rdoCodes = RdoCodes::all();
            return view('register', [
                'connected'        => $xeroCredentials->exists(),
                'error'            => $error ?? null,
                'organisationName' => $organisationName ?? null,
                'id' => $id ?? null,
                'username'         => $username ?? null,
                'organizations'    => $organizations ?? null,
                'rdoCodes'         => $rdoCodes
            ]);

        }else{
            session_start();
            $_SESSION['org'] = $org;
            return redirect()->route('home');
        }
    }

    public function register(OauthCredentialManager $xeroCredentials)
    {
        return view('register');
    }

    public function logoutOrg(){
        session_start();
        session_destroy();
        return redirect()->route('xero.auth.success');
    }

    public function registerOrg(Request $request)
    {
        session_start();
        $input = $request->all();

        $org = new Organizations;
        $org->organization_name = $input['organization_name'];
        $org->email = $input['email'];
        $org->contact_number = $input['contact_number'];
        $org->category = $input['category'];
        $org->first_name = ($input['first_name']) ? $input['first_name'] : '';
        $org->last_name = ($input['last_name']) ? $input['last_name'] : '';
        $org->line_of_business = $input['line_of_business'];
        $org->tin = $input['tin'];
        $org->rdo_code = $input['rdo_code'];
        $org->address_line_1 = $input['address_line_1'];
        $org->province = $input['province'];
        $org->city = $input['city'];
        $org->zip_code = $input['zip_code'];
        $org->tenant_id = $input['tenant_id'];
        $org->save();

        $_SESSION['org'] = $org;
        return redirect()->route('home');
    }
}