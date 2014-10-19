<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 19/10/14
 * Time: 11:08
 */

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use AppBundle\Entity\Taxonomy;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('lanzadera:install')
			->setDescription('Instala y configura la aplicación')
		;
	}

	protected function execute( InputInterface $input, OutputInterface $output )
	{
		$output->writeln('<info>Instalando Lanzadera</info>');
		$output->writeln('');

		$this
			->setupStep($input, $output)
		;

		$output->writeln('<info>Lanzadera configurada correctamente.</info>');
	}

	protected function setupStep(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<info>Configurando base de datos.</info>');

		$this->setupDatabase($input, $output);

		$output->writeln('');
		$output->writeln('<info>Configurando administrador.</info>');

		$this->setupAdmin($output);

		$output->writeln('');

		return $this;
	}

	protected function setupDatabase( InputInterface $input, OutputInterface $output )
	{
		$this
			->runCommand('doctrine:database:create', $input, $output)
			->runCommand('doctrine:schema:create', $input, $output)
			->runCommand('assets:install', $input, $output)
			->runCommand('assetic:dump', $input, $output)
		;

		// Create taxonomies
		$em = $this->getContainer()->get('doctrine.orm.entity_manager');
		$em->persist((new Taxonomy())->setName('Category'));
		$em->persist((new Taxonomy())->setName('Tag'));

		// Create groups
		$em->persist(new Group('Colaboradores', 'ROLE_OPER'));
		$em->persist(new Group('Gestores', 'ROLE_STAFF'));
		$em->persist(new Group('Administradores', 'ROLE_ADMIN'));

		$em->flush();
	}


	protected function setupAdmin(OutputInterface $output)
	{
		$dialog = $this->getHelperSet()->get('dialog');

		$user = new User();

		$user->setUsername($dialog->ask($output, '<question>Usuario:</question>'));
		$user->setPlainPassword($dialog->ask($output, '<question>Contraseña:</question>'));
		$user->setEmail($dialog->ask($output, '<question>Email:</question>'));
		$user->setEnabled(true);
		$user->addRole('ROLE_ADMIN');

		$em = $this->getContainer()->get('doctrine.orm.entity_manager');
		$em->persist($user);
		$em->flush();
	}

	protected function runCommand($command, InputInterface $input, OutputInterface $output)
	{
		$this
			->getApplication()
			->find($command)
			->run($input, $output)
		;

		return $this;
	}
}