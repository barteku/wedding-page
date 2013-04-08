<?php

namespace Acme\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Description of InvitationCommand
 *
 * @author bart
 */
class InvitationCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('invitation:send')
            ->setDescription('Send invitations to guests')
            ->addArgument('email', InputArgument::OPTIONAL, 'Who do you want to send invitation to?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $guests = 0;
        
        $im = $this->getContainer()->get('acme.invitation.manager');
        if($email != null){
            $guest = $im->findOneBy(array('email' => $email));
        }else{
            $all = $im->findAll();
        }
        
        
        if($im->sendInvitation($guest)){
            $guests++;
        }
        

        $output->writeln(sprintf('sended to %s', $guests));
    }
    
    
}