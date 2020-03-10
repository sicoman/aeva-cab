<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\CustomException;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class DriverLogin 
{
  /**
   * Return a value for the field.
   *
   * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
   * @param  mixed[]  $args The arguments that were passed into the field.
   * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
   * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
   * @return mixed
   */
  public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
  {

    $emailOrPhone = filter_var($args['emailOrPhone'], FILTER_VALIDATE_EMAIL);
    $credentials = [];

    if ($emailOrPhone) {
      $credentials["email"] = $args['emailOrPhone'];
    } else {
      $credentials["phone"] = $args['emailOrPhone'];
    } 

    $credentials["password"] = $args['password'];

    if (! $token = auth('driver')->attempt($credentials)) {
      throw new CustomException(
        'Authentication Faild',
        'The provided authentication credentials are invalid.',
        'Authentication'
      );
    }

    $driver = auth('driver')->user();

    return [
      'access_token' => $token,
      'driver' => $driver
    ];

  }
}