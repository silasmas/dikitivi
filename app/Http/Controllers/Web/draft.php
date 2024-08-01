




if (!FacadesRequest::is('change_language') AND !FacadesRequest::is('about') AND !FacadesRequest::is('about.entity') AND !FacadesRequest::is('donation') AND !FacadesRequest::is('donated') AND !FacadesRequest::is('transaction.waiting') AND !FacadesRequest::is('transaction.message')) {
            if (session()->has('for_youth')) {
                if (session()->get('for_youth') == 1) {
                    if (Auth::check()) {
                        // Select a user API
                        $this::$user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                        if ($this::$user->data->user->age < 18) {
                            $this::$for_youth = session()->get('for_youth');

                        } else {
                            $this::$for_youth = 0;

                            return view('parental-code');
                        }

                    } else {
                        $this::$for_youth = session()->get('for_youth');

                        if (!FacadesRequest::is('media.datas')) {
                            return redirect()->route('login');
                        }
                    }

                } else {
                    if (Auth::check()) {
                        // Select a user API
                        $this::$user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                        $this::$for_youth = !empty($this::$user->data->user->age) ? ($this::$user->data->user->age < 18 ? 1 : 0) : 1;

                    } else {
                        return redirect()->route('login');
                    }
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $this::$user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    $this::$for_youth = !empty($this::$user->data->user->age) ? ($this::$user->data->user->age < 18 ? 1 : 0) : 1;

                    if (!FacadesRequest::is('media.datas')) {
                        return redirect()->route('login');
                    }

                } else {
                    Session::put('url.intended', URL::previous());

                    return view('welcome');
                }
            }
        }

