<?php

namespace AppBundle\Command;

use AppBundle\Entity\Alice;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddFixturesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:add:fixtures')
            ->setDescription('Add fixtures');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new NativeLoader();
        $data = $loader->loadFile(__DIR__.'/fixtures.yml', ['coucou' => 23]);

        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach ($data->getObjects() as $object) {
            //$em->persist($object);
        }

        $em->flush();

        $array = [
            'parameters' => [
                'coco' => 'blabla',
            ],
            Alice::class => [
                'alice{1..3}' => [
                    'name' => '<{coco}>',
                    'entier' => 44
                ]
            ]
        ];

        $arrayData = $loader->loadData($array, ['coco' => 'yolooo']);

        foreach ($arrayData->getObjects() as $item) {
            $em->persist($item);
        }

        $em->flush();
    }
}
