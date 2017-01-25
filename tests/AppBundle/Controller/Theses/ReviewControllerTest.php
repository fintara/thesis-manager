<?php

namespace AppBundle\Tests\Controller\Theses;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReviewControllerTest extends WebTestCase
{
    /**
     * 1. Open the web app
     * 2. Sign-in with a Reviewer account
     * 3. Select the list of degrees to be reviewed
     * must see "An application supporting the organization of social sport events"
     * 4. Choose a thesis
     * 5. Fill form and upload file
     * 6. Expect success message.
     */
    public function testUploadTheReview()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('POST', '/login', [
            '_email' => 'abc@teacher.org',
            '_pass' => '123'
        ]);

        $crawler = $client->request('GET', '/theses/to-review');

//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("An application supporting the organization of social sport events")')->count()
//        );

        $crawler = $client->click($crawler->selectLink('Details')->link());

//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("Submit Review")')->count()
//        );

        $crawler = $client->click($crawler->selectLink('Submit Review')->link());

        $form = $crawler->selectButton('Submit')->form();

        $form['form[file]']->upload(__DIR__.'/../../../dummy_file.zip');
        $form['form[title]']->setValue('Test Review');
        $form['form[grade]']->select(5.0);

        $crawler = $client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("You successfully submitted a review")')->count()
        );

        $reviews = $client->getKernel()->getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Review')
            ->findByTitle('Test Review');

        $this->assertGreaterThan(0, count($reviews));

        $review = $reviews[0];

        $this->assertEquals(5.0, $review->getGrade());
    }
//    public function testShowPost()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/post/hello-world');
//
//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("Hello World")')->count()
//        );
//    }
}
