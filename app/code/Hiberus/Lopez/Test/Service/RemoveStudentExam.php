<?php

namespace Hiberus\Lopez\Test\Service;

use Hiberus\Lopez\Exception\StudentExamCouldNotDeletedException;
use Hiberus\Lopez\Service\GetApiStudentsExams;
use Mockery;
use PHPUnit\Framework\TestCase;
use PHPStan\DependencyInjection\ParameterNotFoundException;

/**
 * Class RemoveStudentExam
 * @package Hiberus\Lopez\Test
 */
class RemoveStudentExam extends TestCase
{

    /**
     * @test
     */
    public function removeStudentExamShouldReturnExceptionWhenRequestIsNotValid()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andThrow(new \Exception('The request method is not valid.'));

        $this->expectException(\Exception::class);
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api         = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $api->removeExamById();
    }

    /**
     * @test
     */
    public function removeStudentExamShouldReturnExceptionWhenParametersMissing()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('canRemoveExam')
            ->times(1)
            ->andThrow(new ParameterNotFoundException('Missing parameters.'));
        $this->expectException(ParameterNotFoundException::class);
        $helperApiClientMock->_requestParams = ['lastname' => 'Unit', 'mark' => 7.99];
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $api->removeExamById();
    }

    /**
     * @test
     */
    public function removeStudentExamShouldReturnStringWhenStudentExamDeleted()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('canRemoveExam')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('removeStudentExamById')
            ->times(1)
            ->andReturnTrue();
        $helperApiClientMock->_requestParams = ['id_exam' => '23'];
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $this->assertEquals(json_encode(
            [
                'status' => true,
                'message' => 'The exam with id ' . $helperApiClientMock->_requestParams['id_exam'] . ' has been deleted.'
            ]
        ), $api->removeExamById());

    }

    /**
     * @test
     */
    public function removeStudentExamShouldReturnExceptionWhenStudentExamNotDeleted()
    {
        $helperApiClientMock = Mockery::mock('Hiberus\Lopez\Helper\Api');
        $helperApiClientMock->shouldReceive('validateRequest')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('canRemoveExam')
            ->times(1)
            ->andReturnNull();
        $helperApiClientMock->shouldReceive('removeStudentExamById')
            ->times(1)
            ->andThrow(new StudentExamCouldNotDeletedException('The student exam could not be deleted.'));
        $this->expectException(StudentExamCouldNotDeletedException::class);
        $helperApiClientMock->_requestParams = ['id_exam' => '23'];
        $http        = Mockery::mock(\Magento\Framework\App\Request\Http::class);
        $jsonFactory = Mockery::mock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $api = new GetApiStudentsExams($http, $jsonFactory, $helperApiClientMock);
        $api->removeExamById();
    }
}
