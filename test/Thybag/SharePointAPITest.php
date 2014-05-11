<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 4/26/14
 * Time: 5:26 PM
 */

namespace test\Thybag;

chdir(dirname(__FILE__));
require_once('../../SharePointAPI.php');

use Thybag\SharePointAPI;

class SharePointAPITest extends \PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass() {

    }

    protected function setUp() {
        parent::setUp();


    }


    protected function tearDown() {

    }

    public function getLimitedListsDataProvider() {
        $getLimitedListsResults1 = <<<XML1
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
               xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <GetListCollectionResponse xmlns="http://schemas.microsoft.com/sharepoint/soap/">
            <GetListCollectionResult>
                <Lists>
                    <List DocTemplateUrl=""
                          DefaultViewUrl="/wwa/Admin/OCIO/ciodept/SystemsDevelopment/ESE/internalarea/Lists/Announcements/AllItems.aspx"
                          MobileDefaultViewUrl="" ID="{C0E168F3-A1BB-46A9-B286-12B0752A542E}" Title="Announcements"
                          Description="Use this list to track upcoming events, status updates or other team news."
                          ImageUrl="/_layouts/images/itann.png" Name="{C0E168F3-A1BB-46A9-B286-12B0752A542E}"
                          BaseType="0" FeatureId="00bfea71-d1ce-42de-9c63-a44004ce0104" ServerTemplate="104"
                          Created="20120508 18:45:32" Modified="20120508 18:45:33" LastDeleted="20120508 18:45:32"
                          Version="0" Direction="none" ThumbnailSize="" WebImageWidth="" WebImageHeight=""
                          Flags="536875008" ItemCount="1" AnonymousPermMask="0" RootFolder="" ReadSecurity="1"
                          WriteSecurity="1" Author="12" EventSinkAssembly="" EventSinkClass="" EventSinkData=""
                          EmailAlias="" WebFullUrl="/wwa/Admin/OCIO/ciodept/SystemsDevelopment/ESE/internalarea"
                          WebId="386ab822-8879-4410-9be5-ac726d0bab31" SendToLocation=""
                          ScopeId="ebe83d87-2be1-47a4-9a2c-4f454f31bb22" MajorVersionLimit="0"
                          MajorWithMinorVersionsLimit="0" WorkFlowId="" HasUniqueScopes="False"
                          NoThrottleListOperations="False" HasRelatedLists="" AllowDeletion="True"
                          AllowMultiResponses="False" EnableAttachments="True" EnableModeration="False"
                          EnableVersioning="False" HasExternalDataSource="False" Hidden="False" MultipleDataList="False"
                          Ordered="False" ShowUser="True" EnablePeopleSelector="False" EnableResourceSelector="False"
                          EnableMinorVersion="False" RequireCheckout="False" ThrottleListOperations="False"
                          ExcludeFromOfflineClient="False" EnableFolderCreation="False" IrmEnabled="False"
                          IsApplicationList="False" PreserveEmptyValues="False" StrictTypeCoercion="False"
                          EnforceDataValidation="False" MaxItemsPerThrottledOperation="20000"/>
                </Lists>
            </GetListCollectionResult>
        </GetListCollectionResponse>
    </soap:Body>
</soap:Envelope>
XML1;

        $getLimitedListsExpected1 = array(
            'doctemplateurl'                => '',
            'defaultviewurl'                => '/wwa/Admin/OCIO/ciodept/SystemsDevelopment/ESE/internalarea/Lists/Announcements/AllItems.aspx',
            'mobiledefaultviewurl'          => '',
            'id'                            => '{C0E168F3-A1BB-46A9-B286-12B0752A542E}',
            'title'                         => 'Announcements',
            'description'                   => 'Use this list to track upcoming events, status updates or other team news.',
            'imageurl'                      => '/_layouts/images/itann.png',
            'name'                          => '{C0E168F3-A1BB-46A9-B286-12B0752A542E}',
            'basetype'                      => 0,
            'featureid'                     => '00bfea71-d1ce-42de-9c63-a44004ce0104',
            'servertemplate'                => 104,
            'created'                       => '20120508 18:45:32',
            'modified'                      => '20120508 18:45:33',
            'lastdeleted'                   => '20120508 18:45:32',
            'version'                       => 0,
            'direction'                     => 'none',
            'thumbnailsize'                 => '',
            'webimagewidth'                 => '',
            'webimageheight'                => '',
            'flags'                         => 536875008,
            'itemcount'                     => 1,
            'anonymouspermmask'             => 0,
            'rootfolder'                    => '',
            'readsecurity'                  => 1,
            'writesecurity'                 => 1,
            'author'                        => 12,
            'eventsinkassembly'             => '',
            'eventsinkclass'                => '',
            'eventsinkdata'                 => '',
            'emailalias'                    => '',
            'webfullurl'                    => '/wwa/Admin/OCIO/ciodept/SystemsDevelopment/ESE/internalarea',
            'webid'                         => '386ab822-8879-4410-9be5-ac726d0bab31',
            'sendtolocation'                => '',
            'scopeid'                       => 'ebe83d87-2be1-47a4-9a2c-4f454f31bb22',
            'majorversionlimit'             => 0,
            'majorwithminorversionslimit'   => 0,
            'workflowid'                    => '',
            'hasuniquescopes'               => FALSE,
            'nothrottlelistoperations'      => FALSE,
            'hasrelatedlists'               => '',
            'allowdeletion'                 => TRUE,
            'allowmultiresponses'           => FALSE,
            'enableattachments'             => TRUE,
            'enablemoderation'              => FALSE,
            'enableversioning'              => FALSE,
            'hasexternaldatasource'         => FALSE,
            'hidden'                        => FALSE,
            'multipledatalist'              => FALSE,
            'ordered'                       => FALSE,
            'showuser'                      => TRUE,
            'enablepeopleselector'          => FALSE,
            'enableresourceselector'        => FALSE,
            'enableminorversion'            => FALSE,
            'requirecheckout'               => FALSE,
            'throttlelistoperations'        => FALSE,
            'excludefromofflineclient'      => FALSE,
            'enablefoldercreation'          => FALSE,
            'irmenabled'                    => FALSE,
            'isapplicationlist'             => FALSE,
            'preserveemptyvalues'           => FALSE,
            'stricttypecoercion'            => FALSE,
            'enforcedatavalidation'         => FALSE,
            'maxitemsperthrottledoperation' => 20000
        );

        return array(
            array(
                $getLimitedListsResults1,
                $getLimitedListsExpected1
            )
        );
    }
    public static function tearDownAfterClass() {

    }
}
 