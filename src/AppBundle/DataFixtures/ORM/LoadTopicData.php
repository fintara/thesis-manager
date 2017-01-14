<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 14/01/2017
 * Time: 00:52
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Topic;
use AppBundle\Entity\Worker;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadTopicData extends AbstractFixture
implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ObjectManager
     */
    private $om;

    public function load(ObjectManager $manager)
    {
        $this->om = $manager;

        $topics = [
            [
                'title' => 'An application supporting the organization of social sport events',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting the work of organizer of group events',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting the management of rental units in resorts',
                'sv'    => 1
            ],
            [
                'title' => 'An application for a private dental office',
                'sv'    => 1
            ],
            [
                'title' => 'An application for a private veterinary office',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting questionnaires',
                'sv'    => 1
            ],
            [
                'title' => 'An application for product wholesale',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting the work of a courier',
                'sv'    => 1
            ],
            [
                'title' => 'An application to support the functioning of a pizzeria',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting the accounting of employees\' working time',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting the home budget management',
                'sv'    => 1
            ],
            [
                'title' => 'An application supporting the reservation and sales of cinema tickets',
                'sv'    => 1
            ],
            [
                'title' => 'Development of laboratory tool for the purpose of designing control systems for a PTZ camera',
                'sv'    => 2
            ],
            [
                'title' => 'Development of application for video data acquisition (video stream or single images) that are sent through the mobile phone',
                'sv'    => 2
            ],
            [
                'title' => 'Development of computer simulations of selected dynamic processes in the MASON (MultiAgent SimulatiON) software',
                'sv'    => 2
            ],
            [
                'title' => 'Development of computer simulations of selected dynamic processes using ANYLOGIC',
                'sv'    => 2
            ],
            [
                'title' => 'Development of graphical design environment for performing computer simulations of biologically plausible neural networks',
                'sv'    => 2
            ],
            [
                'title' => 'Android mobile application for monitoring and recording data from selected device sensors',
                'sv'    => 3
            ],
            [
                'title' => 'Web application for registration of users and submission and browsing articles for the conference built in selected PHP framework',
                'sv'    => 3
            ],
            [
                'title' => 'RESTful style Web service for entering and browsing information of the selected format',
                'sv'    => 3
            ],
            [
                'title' => 'Mobile application for Android recording selected parameters of wireless transmission',
                'sv'    => 3
            ],
            [
                'title' => 'Web application supporting fitness club activities',
                'sv'    => 4
            ],
            [
                'title' => 'Application supporting the integration of storage system with online store',
                'sv'    => 4
            ],
            [
                'title' => 'System for archiving images - a web application with mobile access',
                'sv'    => 4
            ],
            [
                'title' => 'Online music store in ASP.NET MVC 6 technology',
                'sv'    => 4
            ],
            [
                'title' => 'System supporting sports activities- a web application with mobile access',
                'sv'    => 4
            ],
            [
                'title' => 'Online video converter',
                'sv'    => 4
            ],
            [
                'title' => 'Application development in the Salesforce technology for supporting recruitment process',
                'sv'    => 5
            ],
            [
                'title' => 'Developing a management system for virtual networks',
                'sv'    => 5
            ],
            [
                'title' => 'Development of PLC simulator for Siemens S7-200',
                'sv'    => 5
            ],
            [
                'title' => 'Visualisation of the lighting control with Arduino platform',
                'sv'    => 5
            ],
            [
                'title' => 'Developing a system to track people inside the building using wireless technologies',
                'sv'    => 5
            ],
            [
                'title' => 'Development of people tracking system based on video in poor lighting conditions',
                'sv'    => 5
            ],
        ];

        for($i = 0; $i < count($topics); $i++) {
            $topic = $this->createTopic($topics[$i]);
        }

        $this->om->flush();
    }

    private function createTopic(array $data)
    {
        $topic = new Topic();

        $topic->setTitle($data['title']);
        $topic->setSupervisor($this->getReference('teacher-'.$data['sv']));
        $topic->setStatus(Topic::STATUS_APPROVED);

        $this->om->persist($topic);

        return $topic;
    }

    public function getOrder()
    {
        return 2;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}