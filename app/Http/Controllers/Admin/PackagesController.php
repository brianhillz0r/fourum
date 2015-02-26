<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;
use Fourum\Model\PackagesEnabled;
use Illuminate\Support\Facades\App;

class PackagesController extends AdminController
{
    public function index()
    {
        $providers = config('app.providers');

        $packages = [];

        foreach ($providers as $providerName) {
            if (is_subclass_of($providerName, 'Fourum\Support\ServiceProvider')) {
                $package = new $providerName(App::make('app'));
                if ($package->isPackage()) {
                    $metaData = new \StdClass;
                    $metaData->package = $package;
                    $metaData->isEnabled = PackagesEnabled::isEnabled($providerName);
                    $metaData->packageClass = urlencode($providerName);
                    $packages[] = $metaData;
                }
            }
        }

        return view('packages.index', ['packages' => $packages]);
    }

    public function enable($package)
    {
        PackagesEnabled::add($package);
        return redirect()->back();
    }

    public function disable($package)
    {
        PackagesEnabled::remove($package);
        return redirect()->back();
    }
}