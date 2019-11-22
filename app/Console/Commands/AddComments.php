<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserController;
use Illuminate\Console\Command;

class AddComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:comment {id?} {comments?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will use to append comments to existing user\'s comment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $params = $this->arguments();
        // This function will create a custom request object to handle the request params.
        $request = createRequestObject($params);
        $user = new UserController();
        $response = $user->postComment($request);
        if($response){
            $this->info($response->getData()->Message);
        }
    }
}
