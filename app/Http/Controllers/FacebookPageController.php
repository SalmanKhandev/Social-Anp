<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Facebook;


class FacebookPageController extends Controller
{
    private $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v12.0',
            'default_access_token' => 'EAAD9Hh3uyzYBOZBeV2kX9XNU28zuZAdFuRCSKquG6EGsdUeDcuH605fDZBDyZAqIVDuHN3PbRXpOPH0EZCNHvGN59ICxinPkPlLWKkNZA6eo7plUNz6iy8tZCuxSwkxEeH2N4tlyT2aGTvv7C3Q4UJ5aZBD1NzGbjBE1vYCFZBiibFCT3Ihi0L56j5lo9mtBtICtKSONfvydW1ZA9jKGreBrd82m6Yg6eXZCzQ4uzlePLHyRyVdbyNnrOpCBAh0MYUkGqa3yAZDZD',

        ]);
    }

    public function getPageData($pageId)
    {
        try {
            $response = $this->fb->get("/$pageId?fields=id,name,about,picture", 'EAAD9Hh3uyzYBOZBeV2kX9XNU28zuZAdFuRCSKquG6EGsdUeDcuH605fDZBDyZAqIVDuHN3PbRXpOPH0EZCNHvGN59ICxinPkPlLWKkNZA6eo7plUNz6iy8tZCuxSwkxEeH2N4tlyT2aGTvv7C3Q4UJ5aZBD1NzGbjBE1vYCFZBiibFCT3Ihi0L56j5lo9mtBtICtKSONfvydW1ZA9jKGreBrd82m6Yg6eXZCzQ4uzlePLHyRyVdbyNnrOpCBAh0MYUkGqa3yAZDZD');
            $page = $response->getGraphPage();

            // Handle the retrieved page data as needed
            dd($page);
            return view('facebook.page', ['page' => $page]);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Handle exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
