<?php namespace Fourum\Console\Commands;

use Fourum\Model\PackagesEnabled;
use Illuminate\Console\Command;

use Carbon\Carbon;
use Fourum\Model\Forum;
use Fourum\Model\Forum\Type;
use Fourum\Model\Group;
use Fourum\Model\Node;
use Fourum\Model\User;
use Fourum\Permission\Eloquent\GroupPermissionRepository;
use Fourum\Permission\Permission;
use Fourum\Repository\RepositoryRegistry;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install Fourum';

	/**
	 * @var RepositoryRegistry
	 */
	private $repos;

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->repos = App::make('Fourum\Repository\RepositoryRegistry');
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->info('Installing...');

		$this->setupDatabase();

		$this->info('Building settings...');

		$this->info('Bootstrapping the forum...');

		$this->bootstrap();

		$this->info('');
		$this->info('Done!');
	}

	private function bootstrap()
	{
		$this->bootstrapForums();
		$this->bootstrapGroups();
		$this->bootstrapUsers();
		$this->bootstrapPackages();
	}

	private function bootstrapPackages()
	{
		PackagesEnabled::add('Fourum\Message\MessageServiceProvider');
		PackagesEnabled::add('Fourum\Warning\WarningServiceProvider');
	}

	private function bootstrapUsers()
	{
		$user = new User();
		$user->setEmail('me@willpillar.com');
		$user->setPassword('blobby');
		$user->setUsername('wpillar');
		$user->setBirthDate(Carbon::createFromDate(1989, 9, 19));
		$user->save();

		$groupsRepo = $this->repos->get('group');
		$group = $groupsRepo->getByName('Administrators');

		$userGroupsRepo = $this->repos->get('user.group');
		$userGroupsRepo->assign($user, $group);

		$user = new User();
		$user->setEmail('will@graze.com');
		$user->setPassword('blobby');
		$user->setUsername('pillar89');
		$user->setBirthDate(Carbon::createFromDate(1989, 9, 19));
		$user->save();
	}

	private function bootstrapForums()
	{
		$root = Node::create(array('forum_id' => null));

		$typeForum = new Type();
		$typeForum->name = 'forum';
		$typeForum->save();

		$typeCategory = new Type();
		$typeCategory->name = 'category';
		$typeCategory->save();

		$category = new Forum();
		$category->title = "My Category";
		$category->type = $typeCategory->id;
		$category->save();

		$forum = new Forum();
		$forum->title = "My Forum";
		$forum->type = $typeForum->id;
		$forum->save();

		$categoryNode = Node::create(array('forum_id' => $category->id));
		$categoryNode->makeChildOf($root);

		$forumNode = Node::create(array('forum_id' => $forum->id));
		$forumNode->makeChildOf($categoryNode);
	}

	private function bootstrapGroups()
	{
		$group = new Group();
		$group->name = "Administrators";
		$group->save();

		$permission = new Permission(
			GroupPermissionRepository::CAN_ADMINISTRATE,
			true,
			$group
		);

		$permissionRepo = $this->repos->get('group.permission');
		$permissionRepo->save($permission);
	}

	/**
	 * Setup database tables
	 *
	 * @return void
	 */
	private function setupDatabase()
	{
		$this->info('Dropping existing tables...');

		$this->dropExistingTables();

		$this->info('Loading table schemas...');

		$closures = $this->loadTableClosures();

		$this->info('Creating tables...');

		foreach ($closures as $table => $closure) {
			Schema::create($table, $closure);
		}

		$this->info('Tables created.');
	}

	/**
	 * Load closures for creating tables.
	 *
	 * @return array
	 */
	private function loadTableClosures()
	{
		return array(
			'sessions' => function ($t) {
				$t->string('id')->unique();
				$t->text('payload');
				$t->integer('last_activity');
			},
			'password_resets' => function ($table) {
				$table->string('email')->index();
				$table->string('token')->index();
				$table->timestamp('created_at');
			},
			'users' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('email')->unique();
				$table->string('password', 60);
				$table->string('username', 16)->unique();
				$table->date('birthdate')->nullable()->default(NULL);
				$table->rememberToken();
				$table->timestamps();
				$table->softDeletes();
			},
			'groups' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('name');
				$table->timestamps();
				$table->softDeletes();
			},
			'user_groups' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('user_id')->unsigned()->index();
				$table->integer('group_id')->unsigned()->index();
				$table->timestamps();
				$table->softDeletes();
			},
			'forums' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('title');
				$table->integer('type')->unsigned();
				$table->timestamps();
				$table->softDeletes();
			},
			'forum_type' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('name');
				$table->timestamps();
				$table->softDeletes();
			},
			'tree' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id');
				$table->integer('parent_id')->nullable();
				$table->integer('left')->nullable();
				$table->integer('right')->nullable();
				$table->integer('depth')->nullable();
				$table->integer('forum_id')->unsigned()->nullable();

				// Add needed columns here (f.ex: name, slug, path, etc.)
				// $table->string('name', 255);

				$table->timestamps();

				// Default indexes
				// Add indexes on parent_id, left, right columns by default. Of course,
				// the correct ones will depend on the application and use case.
				$table->index('parent_id');
				$table->index('left');
				$table->index('right');
			},
			'threads' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('title');
				$table->integer('user_id')->unsigned()->index();
				$table->integer('forum_id')->unsigned()->index();
				$table->integer('views')->unsigned()->default(0);
				$table->timestamps();
				$table->softDeletes();
			},
			'posts' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('user_id')->unsigned()->index();
				$table->integer('thread_id')->unsigned()->index();
				$table->text('content');
				$table->timestamps();
				$table->softDeletes();
			},
			'settings' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('namespace');
				$table->string('name');
				$table->string('title');
				$table->string('value');
				$table->string('description');
				$table->string('type');
				$table->string('options')->nullable();
				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('namespace', 'name'));
			},
			'user_permissions' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('user_id')->unsigned()->index();
				$table->string('name')->index();
				$table->tinyInteger('value')->unsigned()->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('user_id', 'name'));
			},
			'user_roaming_permissions' => function ($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('user_id')->unsigned()->index();
				$table->string('foreign_key')->index();
				$table->integer('foreign_id')->unsigned()->index();
				$table->string('name')->index();
				$table->tinyInteger('value')->unsigned()->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('user_id', 'foreign_key', 'foreign_id', 'name'), 'user_roaming_permissions_unique');
			},
			'group_permissions' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('group_id')->unsigned()->index();
				$table->string('name')->index();
				$table->tinyInteger('value')->unsigned()->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('group_id', 'name'));
			},
			'group_roaming_permissions' => function ($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('group_id')->unsigned()->index();
				$table->string('foreign_key')->index();
				$table->integer('foreign_id')->unsigned()->index();
				$table->string('name')->index();
				$table->tinyInteger('value')->unsigned()->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('group_id', 'foreign_key', 'foreign_id', 'name'), 'group_roaming_permissions_unique');
			},
			'thread_permissions' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('thread_id')->unsigned()->index();
				$table->string('name')->index();
				$table->tinyInteger('value')->unsigned()->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('thread_id', 'name'));
			},
			'forum_permissions' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('forum_id')->unsigned()->index();
				$table->string('name')->index();
				$table->tinyInteger('value')->unsigned()->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('forum_id', 'name'));
			},
			'rules' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('rule', 255);

				$table->timestamps();
				$table->softDeletes();
			},
			'reports' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('message', 255);
				$table->integer('user_id')->unsigned()->index();
				$table->integer('foreign_id')->unsigned()->index();
				$table->string('foreign_key', 25)->index();
				$table->tinyInteger('read')->default(0)->index();

				$table->timestamps();
				$table->softDeletes();
				$table->unique(array('user_id', 'foreign_id', 'foreign_key'));
			},
			'notifications' => function($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('user_id')->unsigned()->index();
				$table->integer('type')->unsigned()->index();
				$table->string('foreign_key', 25);
				$table->integer('foreign_id')->unsigned();
				$table->integer('read')->unsigned()->default(0);

				$table->timestamps();
				$table->softDeletes();
			},
			'notification_types' => function ($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->string('name', 255)->unique();

				$table->timestamps();
				$table->softDeletes();
			},
			'packages_enabled' => function ($table) {
				$table->engine = "InnoDb";

				$table->string('name', 255)->unique();
			},
			'effects' => function ($table) {
				$table->engine = "InnoDb";

				$table->increments('id')->unsigned();
				$table->integer('foreign_id')->unsigned()->index();
				$table->string('foreign_key', 25)->index();
				$table->string('effect', 100);
				$table->string('permission', 25)->index();
				$table->tinyInteger('permission_value')->unsigned();
				$table->timestamp('expires');

				$table->timestamps();
				$table->unique(['foreign_id', 'foreign_key', 'permission']);
			}
		);
	}

	/**
	 * Drops existing tables from the schema.
	 *
	 * @return void
	 */
	private function dropExistingTables()
	{
		$tableNames = array_keys($this->loadTableClosures());

		foreach ($tableNames as $table) {
			Schema::dropIfExists($table);
		}

		Schema::dropIfExists('messages');
		Schema::dropIfExists('warnings');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
//			['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
//			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
