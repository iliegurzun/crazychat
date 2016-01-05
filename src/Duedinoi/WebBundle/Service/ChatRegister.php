<?php
/**
 * Created by PhpStorm.
 * User: ilie.gurzun
 * Date: 05/1/2016
 * Time: 2:31 PM
 */

namespace Duedinoi\WebBundle\Service;


class ChatRegister
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function registerUser($user)
    {
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://api.quickblox.com/users.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $encoded = '';
        // include GET as well as POST variables; your needs may vary.
        $encoded .='user[login]='.$user->getUsername();
        $encoded .='user[password]=crazychat';
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);

        // $output contains the output string
        $output = curl_exec($ch);
        dump($output);die;

        // close curl resource to free up system resources
        curl_close($ch);
    }
}