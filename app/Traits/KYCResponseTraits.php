<?php
/**
 * Created by PhpStorm.
 * User: Bright
 * Date: 11/8/2020
 * Time: 6:05 AM
 */
namespace App\Traits;

trait KYCResponseTraits {
    public function KYCResponse($name)
    {
        $response = [
          ['userName' => 'bright', 'refId' => '1234'],
            ['userName' => 'james', 'refId' => '1231'],
        ];

        foreach ($response as  $key => $item) {
            if ($name === $item['userName']) {
                return $item;
            } else {
                return null;
            }
        }
    }
}