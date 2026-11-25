<?php

namespace App\View\Composers;

use Illuminate\View\View;

class IsAppleComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     */

    public function compose(View $view)
    {
        $userAgent = request()->header('User-Agent');

        $patterniOS = '/(iPhone|iPod|iPad)/i';
        $isIOSDevice = false;
        if (preg_match($patterniOS, $userAgent)) {
            $isIOSDevice = true;
        }


        $userAgent = request()->header('User-Agent');

        $patternMAC = '/(Mac)/i';
        $isMacDevice = false;
        if (preg_match($patternMAC, $userAgent)) {
            $isMacDevice = true;
        }

        $view->with('isApple', ['isIOSDevice' => $isIOSDevice,'isMacDevice' =>  $isMacDevice]);


    }
}
