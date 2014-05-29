<?php

class Users
{
  
  public static function get_all() 
  {
    try
    {
      $users = DB::table('users')->get();
      return $users;
    }

    catch(Exception $e)
    {
      Log::write('error', $e->getMessage());
      throw $e;
    }
  }
  

  public static function find_by_id($id)
  {
    try
    {
      $user = DB::table('users')->where('id', '=', $id)->first();
      return $user;
    }

    catch(Exception $e)
    {
      Log::write('error', $e->getMessage());
      throw $e;
    }
  }

  public static function get_by_column($col1, $col2)
  {
    try
    {
     return DB::table('users')->get(array($col1, $col2));
   }

   catch(Exception $e)
   {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}

  //gets two columns and returns them as an associated array
public static function get_columns_as_associative_array($col1, $col2)
{
  try
  {
    $users_data = DB::table('users')->get(array($col1, $col2));
    foreach ($users_data as $key => $value)
    {
      $users[$value->id] = $value->username;
    }

    return $users;
  }

  catch(Exception $e)
  {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}

public static function insert_verification_code($id, $type, $code )
{
  try
  {
      $success = DB::table('users')
      ->where('id', '=', $id)
      ->update(array(
          $type . "_verification_code" => $code
        ));

      return $success;
    }

  catch(Exception $e)
  {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}

public static function update_verified($id, $type, $status)
{
  try
  {
    $success = DB:: table('users')
    ->where('id', '=', $id)
    ->update(array(
      $type.'_verified' => $status,
      ));

    return $success;
  }

  catch(Exception $e)
  {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}

public static function create($input)
{
  Log::write("info", "We're here too!");
  try
  {
    $password = Hash::make($input['password']);

    $success = DB::table('users')->insert(array(
      'username' => $input['username'],
      'password' => $password,
      'email' => $input['email'],
      'phone' => $input['phone'],
      'carrier' => $input['carrier'],
      'is_admin' => $input['is_admin'],
      'email_verified' => 0,
      'phone_verified' => 0
      ));

    Log::write('info', $success);

    return $success;
  }

  catch(Exception $e)
  {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}

public static function update($input)
{

  Log::write("info", print_r($input));

  try
  {
    $success = DB::table('users')
    ->where('id', '=', $input['id'])
    ->update(array(
      'username' => $input['username'],
      'email' => $input['email'],
      'phone' => $input['phone'],
      'carrier' => $input['carrier'],
      'is_admin' => $input['is_admin'],
      'email_verified' => $input['email_verified'],
      'phone_verified' => $input['phone_verified']
      ));

    return $success;
  }

  catch(Exception $e)
  {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}

public static function delete($id)
{
  try
  {
    $success = DB::table('users')->delete($id);
    return $success;
  }

  catch(Exception $e)
  {
    Log::write('error', $e->getMessage());
    throw $e;
  }
}
}