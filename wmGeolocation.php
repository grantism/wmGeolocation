<?php
/**
 * World Manager geolocation plugin for Joomla.
 * This is required to use the wmCareers & wmLanguageSwitch plugins.
 * @package wmGeolocation
 * @version 1.0
 * @author Grant McNally <grantmcnally@gmail.com>
 * @link https://github.com/grantism/wmGeolocation
 */

defined('_JEXEC') or die;

require_once JPATH_PLUGINS . '/system/wmGeolocation/geoip/vendor/autoload.php';

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Plugin\CMSPlugin as JPlugin;
use GeoIp2\Database\Reader;

class PlgSystemWmGeolocation extends JPlugin {

    private $countryIsoCode = 'US';

    /**
     * PlgSystemWmGeolocation constructor.
     * @param object $subject
     * @param array $config
     */
    public function __construct(&$subject, $config) {
        parent::__construct($subject, $config);

        $reader = new Reader(JPATH_PLUGINS . '/system/wmGeolocation/geoip/GeoLite2-Country.mmdb');
        $ip = $_SERVER['REMOTE_ADDR'];
        try {
            $geoIp = $reader->country($ip);
            $this->countryIsoCode = $geoIp->country->isoCode;
        }
        catch (Exception $e) {
            /**
             * Exception is thrown if IP address isn't found in the database.
             * This mostly happens on local networks during development & testing.
             */
        }

        // Set global var so users location can be accessed in the site.
        JFactory::getApplication()->set('wmGeolocation', $this);
    }

    /**
     * @return string
     */
    public function getCountryIsoCode() {
        return $this->countryIsoCode;
    }

    /**
     * @return bool
     */
    public function isSpanish() {
        $spanishCountries = array(
            'AR', //Argentina
            'BO', //Bolivia
            'CL', //Chile
            'CO', //Colombia
            'CR', //Costa Rica
            'CU', //Cuba
            'DO', //Dominican Republic
            'EC', //Ecuador
            'ES', //Spain
            'GQ', //Equatorial Guinea
            'GT', //Guatemala
            'HN', //Honduras
            'MX', //Mexico
            'NI', //Nicaragua
            'PA', //Panama
            'PE', //Peru
            'PR', //Puerto Rico
            'PY', //Paraguay
            'SV', //El Salvador
            'UY', //Uruguay
            'VE', //Venezuela
        );

        return in_array($this->getCountryIsoCode(), $spanishCountries);
    }

    /**
     * @return bool
     */
    public function isEnglish() {
        $englishCountries = array(
            'AU', //Australia
            'GB', //UK
            'NZ', //New Zealand
            'US', //USA
        );

        return in_array($this->getCountryIsoCode(), $englishCountries);
    }

    /**
     * @return bool
     */
    public function isAustralia() {
        return $this->getCountryIsoCode() == 'AU';
    }

    /**
     * @return bool
     */
    public function isUnitedStates() {
        return $this->getCountryIsoCode() == 'US';
    }
}
