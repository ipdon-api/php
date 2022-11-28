# IPdon PHP integration

[IPdon](https://ipdon.com) is a fast IP intelligence solution. This is the official PHP library which benchmarks as the fastest PHP library for obtaining data from any IP. 

Natively it provides: 
* Direct access to Geographical, Network, Company or Domain based information on any IP in the world.
* A 30-40x speed increase versus competing services due to the services algorithm
* Provides a multi-dimensional array response identical to the IPdon service itself.
* Has a free tier without needing an API key (token) Learn more about [plans](https://ipdon.com/pricing) here.

## Usage

### Install

To install using Composer:

```sh
.....
```

### Quickstart

This is an example of calling the service

```PHP
// Leave string '' empty to use the Free tier.
$apiKey = '5ae79d31-6e48-4641-a0fd-bcee9cd30ff6' 
 
$visitorIP = empty($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR'];
 
$IPdon = new IPdon($apiKey);
$retval = $IPdon->query($visitorIP);
print_r($retval);
```

Example response:
```
{   'abuse': {'contacts': ['abuse@amazonaws.com']},
    'domains': ['might-d-light.com'],
    'location': {   'city': 'Dublin',
                    'continent': 'Europe',
                    'country': 'Ireland',
                    'country_iso': 'IE',
                    'currency': 'Euro',
                    'dialcode': '353',
                    'languages': ['en-IE', 'ga-IE'],
                    'latitude': 53.3379,
                    'longitude': -6.2591,
                    'map_image': 'https://staticmap.thisipcan.cyou/?lat=53.3379&lon=-6.2591',
                    'postalcode': 'D02',
                    'region': 'Northern Europe',
                    'state': 'Leinster'},
    'network': {   'cidr_size': 4194304.0,
                   'cidr_subsegment': '34.240.0.0/13',
                   'ip_subsegment_end': '34.247.255.255',
                   'ip_subsegment_end_int': 586678271,
                   'ip_subsegment_start': '34.240.0.0',
                   'ip_subsegment_start_int': 586153984,
                   'ip_type': 'ipv4',
                   'rir': 'arin',
                   'rir_cidr_segment': '34.192.0.0/10'},
    'organization': {   'asn': '16509',
                        'description': 'Amazon NA Prefix',
                        'name': 'NET34'},
    'request': {   'query': '34.241.171.232',
                   'status': 'success',
                   'subscription': False},
    'time': {   'timezone': 'Europe/Dublin',
                'timezone_is_dst': True,
                'timezone_utc_offset': 0.0}}
```
See IPdon documentation for an elaborate description on how to use the API [here](https://ipdon.com/documentation)
