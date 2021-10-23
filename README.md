<!-- ABOUT THE PROJECT -->

## About The Package

Laravel package for multi-user management.

![alt text](screenshot-terminal.PNG)

### Built With

- [Laravel(Backend)](https://laravel.com/)

<!-- GETTING STARTED -->

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

This is an example of how to list things you need to use the software and how to install them.

- Composer

### Package Installation

1.  Edit `composer.json` file. Add github repositories.

    ```
    "repositories": [
         {
             "url": "https://github.com/sislamrafi/laravel-package-multiuser",
             "type": "vcs"
         }
     ],
    ```

2.  Run Composer Require command
    ```sh
    composer require sislamrafi/multiuser:dev-main
    ```
3.  Publish package
    ```sh
    php artisan vendor:publish --provider=Sislamrafi\Webartisan\UsersServiceProvider
    ```
4.  Edit `\config\multiuser.php` file.

    ```
    return [
        'roles' => [
            'superadmin' => [
                'name'=>'Super Admin',
                'id' => 3,
                'redirect' => 'superadmin.user',
                'registerable' => false,
            ],
            'player' => [
                'name'=>'Player Login',
                'id' => 2,
                'redirect' => 'multiuser.root',
                'registerable' => false,
            ],
            
        ],
    ];
    ```

    This step will help you to define various user types.

5.  Edit `\app\Models\User.php` file. add function

    ```
    public function hasRole($role){
        $roles = config('multiuser.roles');
        $role_id = NULL;

        foreach($roles as $key=>$value){
            if($key == $role){
                $role_id = $value['id'];
                break;
            }
        }
        $role = $this->hasMany('App\Models\Role','user_id')->where('role',$role_id)->first();
        
        return $role==NULL?false:true;
    }
    ```

    This step will help you to detect different user types.
6.  Edit `\app\Middleware\RedirectIfAuthenticated.php` file. add function

    ```
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                foreach(config('multiuser.roles') as $key=>$val){
                    if(Auth::user()->hasRole($key)){
                        return redirect(route($val['redirect']));
                        break;
                    }
                }
            }
        }

        return $next($request);
    }
    ```

    This step will help you to detect different user types.
7.  If you add this package to your existing project, don't forget to clear cache
    ```sh
    php artisan optimize:clear
    ```
8.  Setup your middlewares according to your need. Here is a sample
    ```
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(route('multiuser.login').'?user=superadmin');
            }
        }else{
            $user = Auth::guard('web')->user();
            if(!$user->hasRole('superadmin')){
                return response('Unauthorized.', 401);
            }
        }

        return $next($request);
    }
    ```

<!-- USAGE EXAMPLES -->

## Usage


<!-- ROADMAP -->

## Roadmap

See the [open issues](https://github.com/sislamrafi/laravel-package-multiuser/issues) for a list of proposed features (and known issues).

<!-- CONTRIBUTING -->

## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<!-- LICENSE -->

## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->

## Contact

S Islam Rafi - [sislamrafi333@gmail.com](https://www.facebook.com/sislam.rafi/) - email

Project Link: [https://github.com/sislamrafi/webartisan](https://github.com/sislamrafi/laravel-package-multiuser)

<!-- ACKNOWLEDGEMENTS -->
