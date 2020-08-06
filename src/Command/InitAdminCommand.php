<?php

namespace App\Command;

use App\Document\Admin;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitAdminCommand extends Command
{
    protected static $defaultName = 'app:init:admin';

    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct();
        $this->documentManager = $documentManager;
    }

    protected function configure()
    {
        $this->setDescription('初始化管理员账号');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->success('初始化账号开始...');
        $existed = $this->documentManager->getRepository(Admin::class)->findOneBy(['email' => 'admin@163.com']);
        if ($existed) {
            $io->warning('超级管理员账号已创建，请勿重复创建');
            $io->warning("管理员账号：{$existed->getEmail()} 密码：123456");
            return 0;
        }

        $admin = new Admin();
        $admin->setEmail('admin@163.com');
        $admin->setPassword(password_hash('123456',PASSWORD_DEFAULT));
        $admin->setUsername('root');
        $admin->setRoles(['ROLE_ADMIN']);
        $this->documentManager->persist($admin);
        $this->documentManager->flush();

        $io->success('初始化账号成功');

        $io->success("管理员账号：{$admin->getEmail()} 密码：123456");

        return 0;
    }
}
