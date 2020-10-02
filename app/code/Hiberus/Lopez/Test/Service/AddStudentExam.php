<?php

namespace Hiberus\Lopez\Test\Service;

use _HumbugBoxe8a38a0636f4\Nette\Neon\Exception;
use Hiberus\Lopez\Service\GetApiStudentsExams;
use Mockery;
use PHPStan\DependencyInjection\ParameterNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class AddStudentExam
 * @package Hiberus\Lopez\Test
 */
class AddStudentExam extends TestCase
{

    /**
     * @test
     */
    public function addStudentExamShouldReturnExceptionWhenRequestIsNotValid()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andThrow(new \Exception('The request method is not valid.'));

        $this->expectException(\Exception::class);
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api         = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $api->addStudentExam();
    }

    /**
     * @test
     */
    public function addStudentExamShouldReturnExceptionWhenParametersMissing()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('canCreateExam')
            ->times(1)
            ->andThrow(new ParameterNotFoundException('Missing parameters.'));
        $this->expectException(ParameterNotFoundException::class);
        $helperApiClientMock->_requestParams = ['lastname' => 'Unit', 'mark' => 7.99];
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $api->addStudentExam();
    }

    /**
     * @test
     */
    public function addStudentExamShouldReturnStringWhenStudentExamAdded()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('canCreateExam')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('createStudentExam')
            ->times(1)
            ->andReturnTrue();
        $helperApiClientMock->_requestParams = ['firstname' => 'Test', 'lastname' => 'Unit', 'mark' => 7.99];
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $this->assertEquals(json_encode(['status' => true]), $api->addStudentExam());

    }

    /**
     * @test
     */
    public function addStudentExamShouldReturnExceptionWhenStudentExamNotAdded()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('canCreateExam')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('createStudentExam')
            ->times(1)
            ->andThrow(new \Exception('The Student Exam could not be delete.'));
        $this->expectException(Exception::class);
        $helperApiClientMock->_requestParams = ['firstname' => 'Test', 'lastname' => 'Unit', 'mark' => 7.99];
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $api->addStudentExam();
    }
}

