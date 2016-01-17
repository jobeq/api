## jobEQ API authorization

Authorization is required to use [jobEQ API](http://www.jobeq.info/api/). Application should provide valid access token with every API request. Authorization is based on oAuth2 protocol, "client credentials" scenario is used. Note that in order to use jobEQ API application also needs to receive a secret key and ID from jobEQ, please mail jobEQ to register your app. 

### How to start using jobEQ API ?

1. Register your application and receive __app secret__ and __application ID__, by sending email to jobEQ.
2. Authorize application access through __jobEQ authorization service__. 
3. Call API functions through http adding __access token__ to each request.

### Quick start guide
1. Request access token by sending GET request to jobEQ authorization service and providing __app secret__ and __application ID__ in request

       ```
       curl -u app_id:app_secret http://www.jobeq.net/oauth/access_token.php -d 'grant_type=client_credentials'
       ```

2. jobEQ will reply with json containing access token:

       ```
       {"access_token":"4ea347ac369edbe59a0753a5910897f1ea96a798","expires_in":3600,"token_type":"bearer","scope":null}
       ```

3. Perform API requests with access token in header:

       ```
       curl -H -v "Authorization: Bearer 4ea347ac369edbe59a0753a5910897f1ea96a798" http://jobeq.info/api_test/texts/surveys/iwam/EN
       ```
       
4. jobEQ will process resource request and reply according to [API specification](../master/specification.json)


### Error codes and messages

When sending API request authorization service might return a few different error messages. If authorization fails and PAI request can't be processed, server will return "401 Unauthorized" http response code. The error message is sent in "WWW-Authenticate" response header.

- Provided access token is incorrect

       ```
       WWW-Authenticate: bearer realm="Service", error="invalid_token", error_description="The access token provided is invalid"
       ```

- Authorization header is invalid

       ```
       WWW-Authenticate: bearer realm="Service", error="invalid_request", error_description="Malformed auth header"
       ```
       
- Provided access token has expired

       ```
       WWW-Authenticate: bearer realm="Service", error="invalid_token", error_description="The access token provided has expired"
       ```
### Working example

You can find a PHP script which demonstrates interaction with jobEQ API:

<https://github.com/jobeq/api/blob/master/api_test.php>
