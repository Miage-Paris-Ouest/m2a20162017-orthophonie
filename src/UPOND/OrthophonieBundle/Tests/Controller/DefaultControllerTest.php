<?php

namespace UPOND\OrthophonieBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase{

	private $client = null;

    public function setUp(){
        $this->client = static::createClient();
    }
	
	private function logIn(){
        $session = $this->client->getContainer()->get('session');
        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';
        $token = new UsernamePasswordToken('admin', null, $firewallContext);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testFonctionnelLogin(){
		$client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertGreaterThan(0,$crawler->filter('html:contains("Login")')->count());
    }
	
	public function testFonctionnelIndex(){
		$this->logIn();
        $crawler = $this->client->request('GET', '/');
        $this->assertGreaterThan(0,$crawler->filter('html:contains("Exercice")')->count());
	}
}
