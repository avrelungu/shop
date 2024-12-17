<?php

namespace ContainerRsUbhFo;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getUserServiceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Service\User\UserService' shared autowired service.
     *
     * @return \App\Service\User\UserService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Service/User/UserService.php';

        return $container->privates['App\\Service\\User\\UserService'] = new \App\Service\User\UserService(($container->privates['validator'] ?? self::getValidatorService($container)), ($container->services['doctrine.orm.default_entity_manager'] ?? self::getDoctrine_Orm_DefaultEntityManagerService($container)));
    }
}
