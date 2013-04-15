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
        $counter = 0;
        
        $im = $this->getContainer()->get('acme.invitation.manager');
        if($email != null){
            $guests = $im->findBy(array('email' => $email));
            foreach($guests as $guest){
                if($guest->getFirstName() != 'Włodzimierz'){
                    //if($im->sendInvitation($guest)){
                    //    $counter++;
                    //}
                    echo $guest->getFullname();
                }
            }
        }else{
            //$counter = $im->sendToAll();
        }       
        

        $output->writeln(sprintf('sended to %s', $counter));
    }
    
    
}