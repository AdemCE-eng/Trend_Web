<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CleanUpMissingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-up-missing-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up database references to missing avatar and banner files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning up missing file references...');
        
        $avatarsCleaned = 0;
        $bannersCleaned = 0;
        
        // Check avatars
        $usersWithAvatars = User::whereNotNull('avatar')->get();
        foreach ($usersWithAvatars as $user) {
            $avatarPath = public_path('storage/avatars/' . $user->avatar);
            if (!file_exists($avatarPath)) {
                $this->warn("Removing missing avatar reference: {$user->avatar} for user {$user->name}");
                $user->update(['avatar' => null]);
                $avatarsCleaned++;
            }
        }
        
        // Check banners
        $usersWithBanners = User::whereNotNull('banner')->get();
        foreach ($usersWithBanners as $user) {
            $bannerPath = public_path('storage/banners/' . $user->banner);
            if (!file_exists($bannerPath)) {
                $this->warn("Removing missing banner reference: {$user->banner} for user {$user->name}");
                $user->update(['banner' => null]);
                $bannersCleaned++;
            }
        }
        
        $this->info("Cleanup complete! Removed {$avatarsCleaned} avatar references and {$bannersCleaned} banner references.");
        
        return Command::SUCCESS;
    }
}
