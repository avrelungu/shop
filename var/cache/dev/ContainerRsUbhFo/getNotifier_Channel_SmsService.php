<?php

namespace ContainerRsUbhFo;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNotifier_Channel_SmsService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'notifier.channel.sms' shared service.
     *
     * @return \Symfony\Component\Notifier\Channel\SmsChannel
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/notifier/Channel/ChannelInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/notifier/Channel/AbstractChannel.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/notifier/Channel/SmsChannel.php';

        $a = ($container->privates['texter.transports'] ?? $container->load('getTexter_TransportsService'));

        if (isset($container->privates['notifier.channel.sms'])) {
            return $container->privates['notifier.channel.sms'];
        }

        return $container->privates['notifier.channel.sms'] = new \Symfony\Component\Notifier\Channel\SmsChannel($a, NULL);
    }
}
