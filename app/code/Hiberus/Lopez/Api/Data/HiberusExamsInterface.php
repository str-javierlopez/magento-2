<?php

namespace Hiberus\Lopez\Api\Data;

/**
 * Interface HiberusExamsInterface
 * @package Hiberus\Lopez\Api\Data
 */
interface HiberusExamsInterface
{

    /**
     * Key ID Exam
     */
    const ID_EXAM   = 'id_exam';

    /**
     * Key Firstname
     */

    const FIRSTNAME = 'firstname';
    /**
     * Key Lastname
     */

    const LASTNAME  = 'lastname';

    /**
     * Key Mark
     */
    const MARK      = 'mark';

    /**
     * Get id exam
     *
     * @return int|null
     */
    public function getIdExam();

    /**
     * Set id exam
     *
     * @param int $id
     * @return $this
     */
    public function setIdExam($id);

    /**
     * Get firstname
     *
     * @return string|null
     */
    public function getFirstname();

    /**
     * Set Firstname
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname);

    /**
     * Get Lastname
     * @return string | null
     */
    public function getLastname();

    /**
     * Set Lastname
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname);

    /**
     * Get Mark
     * @return float | null
     */
    public function getMark();

    /**
     * Set Mark
     * @param float $mark
     * @return $this
     */
    public function setMark($mark);
}
