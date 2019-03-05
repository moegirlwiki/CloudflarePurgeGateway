# CloudflarePurgeGateway
- This is a nginx+php based standard Squid/Varnish purge request converter for Cloudflare, in EXPERIMENTAL.
- Although we develop this program toward MediaWiki as a substitute of https://github.com/moegirlwiki/MW-Cloudflare/ for backward compatibility, It works with any project using standard Squid/Varnish purge request.


## Dependency
* nginx
* PHP

## Install
* Set up a nginx v-config monitor port other than 80,443. (e.g. 8080) Set the root path to /cf_purge_gw.
* compsoer install.

## Configuration
* Acquire Cloudflare account email and API key, and fill that info into config.php.
(Cloudflare Official help page: https://support.cloudflare.com/hc/en-us/articles/200167836-Where-do-I-find-my-Cloudflare-API-key- )
* set the previous port in your software as a Squid/Varnish cache server address. 

* Mediawiki had a bug since 2015 and still not fixed yet in 2019, which is reported by one of Moegirlpedia volunteer developer in https://phabricator.wikimedia.org/T132538. Mediawiki does not recognizing $wgSquidServers address with port. Therefore effective setting would be: $wgSquidServers = array('127.0.0.1:8080'); $wgSquidServersNoPurge[] = "127.0.0.1";  .

## Security Issue
* At the time we wrote this intro, Cloudflare only offers GLOBAL API KEY toward users not in "Enterprise plan"($5000+). It is possible to acquire original server IP and tons other sensitive info via GLOBAL API KEY. Therefore, it is highly suggested to set config.php with permission 400, and store it in a place not public (not accessible by nginx).
* Limit access to the port with strict firewall rules.
* Cloudflare SDK(and other components by composer) should be updated regularly.

# USE AT YOUR OWN RISK!
