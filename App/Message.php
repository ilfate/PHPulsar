<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App;

/**
 * Message class
 *
 * @author ilfate
 */
class Message
{
    const SESSEION_KEY = 'ilfate_message';

    /**
     * creates message
     *
     * @param String $message
     */
    public static function add($message)
    {
        $request    = Service::getRequest();
        $messages   = $request->getSession(self::SESSEION_KEY);
        $messages[] = $message;
        $request->setSession(self::SESSEION_KEY, $messages);
    }

    public static function getMessages()
    {
        return Service::getRequest()->getSession(self::SESSEION_KEY);
    }

    public static function clear()
    {
        Service::getRequest()->setSession(self::SESSEION_KEY, null);
    }
}
