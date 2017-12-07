<?php
/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This class is an indexed enumeration of all columns present in the template
 * (template.xlsx).
 */

class CsvColumns {
    const TEST_SUITE_NAME_COLUMN = 0;
    const TEST_SUITE_DETAILS_COLUMN = 1;
    const TEST_CASE_NAME_COLUMN = 2;
    const TEST_CASE_SUMMARY_COLUMN = 3;
    const TEST_CASE_PRECONDITIONS_COLUMN = 4;
    const TEST_CASE_STATUS = 5;
    const TEST_CASE_EXE_TYPE_COLUMN = 6;
    const TEST_CASE_IMPORTANCE_COLUMN = 7;
    const TEST_CASE_EXP_EXEC_DURATION = 8;
    const KEYWORDS = 9;
    const STEP_COLUMN = 10;
    const STEP_EXP_RESULT_COLUMN = 11;
    const STEP_EXP_TYPE_COLUMN = 12;
    const TEST_CASE_REQ_TITLE = 13;
    const TEST_CASE_REQ_DOC_ID = 14;
    const CUSTOM_FIELDS_START_COLUMN = 15;
}
