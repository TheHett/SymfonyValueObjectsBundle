# Value Object Bundle

Provides the ability to use popular entity as data types.

At the moment next following types are supported:
- Ip
- EMail
- Integer


Includes `serizlizers` (based on JMS/Serializer) and `param converters`

## Installation

`composer require the-hett/symfony-value-objects-bundle`

## Examples

#### ParamConverter


```php
    /**
     * @Route("/ip/{ip}")
     * @param Ip $ip
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function ipAction(Ip $ip): Response
    {
        // You can work easy with valid data without any additional validators
        // $ip->isV6()
        // $ip->isV4()
        // $ip->getPrintable()
        // $ip->getBinary()
        
        return new Response("Requested ip is {$ip}");
    }
```


```bash
$ curl -i  -s  http://127.0.0.1:8000/ip/127.0.0.1
HTTP/1.1 200 OK
... other headers ...

Hello! Ip is 127.0.0.1

```

```bash
$ curl -i  -s http://127.0.0.1:8000/ip/127.0.0.1.1
HTTP/1.0 400

Can not cast value to Ip address. '127.0.0.1.1' is not an valid IPv4/v6 address

```


