<?php
/**
 * @Author: Ali2vu <751815097@qq.com>
 * @Date: 2022-02-18 10:46:04
 * @LastEditors: Ali2vu
 * @LastEditTime: 2022-02-18 10:46:04
 */

declare(strict_types=1);

namespace HyperfExtend\Command;

use Hyperf\Command\ConfirmableTrait;
use Hyperf\Database\Commands\Migrations\BaseCommand;
use Hyperf\Database\Migrations\Migrator;
use Symfony\Component\Console\Input\InputOption;

class RollbackCommand extends BaseCommand
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last database migration';

    /**
     * The migrator instance.
     *
     * @var \Hyperf\Database\Migrations\Migrator
     */
    protected $migrator;

    /**
     * Create a new migration rollback command instance.
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct();

        $this->migrator = $migrator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDevelop = in_array(env('APP_ENV'), ['develop', 'local']);
        if (!$isDevelop) {
            $this->warn("目前除了开发环境，不允许执行rollback");
            return;
        }

        $doing = $this->confirm("确定是否要执行此操作", false);
        if (!$doing){
            return;
        }
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->migrator->setConnection($this->input->getOption('database') ?? 'default');

        $this->migrator->setOutput($this->output)->rollback(
            $this->getMigrationPaths(),
            [
                'pretend' => $this->input->getOption('pretend'),
                'step' => (int) $this->input->getOption('step'),
            ]
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production'],
            ['path', null, InputOption::VALUE_OPTIONAL, 'The path to the migrations files to be executed'],
            ['realpath', null, InputOption::VALUE_NONE, 'Indicate any provided migration file paths are pre-resolved absolute paths'],
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run'],
            ['step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted'],
        ];
    }
}