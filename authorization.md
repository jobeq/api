## jobEQ API authorization

Authorization is required to use [jobEQ API](http://www.jobeq.info/api/). Application should provide valid access token with every API request. Authorization is based on oAuth2 protocol, "authorization code" scenario is used. Note that in order to use jobEQ API application also needs to receive a secret key and ID from jobEQ, please mail jobEQ to register your app. 

### How to start using jobEQ API ?

1. Register your application and receive __app secret__ and __application ID__, by sending email to jobEQ.
2. Authorize application access through __jobEQ authorization service__. 
3. Call API functions through http adding __access token__ to each request.

### Quick start guide
1. Redirect user to jobEQ login dialog

       ```
       GET http://www.jobeq.net/oauth2/dialog?
       client_id={app-id}
       &redirect_uri={redirect-uri}
       ```

2. jobEQ will reply with authorization code:

       ```
       GET {redirect-uri}?
       code={authorization-code}
       ```

3. Exchange authorization code to access token:

       ```
       GET http://www.jobeq.net/oauth2/access_token?
       client_id={app-id}
       &redirect_uri={redirect-uri}
       &client_secret={app-secret}
       &code={authorization-code}
       ```

4. jobEQ will reply with JSON containing access token:

       ```
       {
        “access_token”: <access-token>,
        “token_type”:<type>,
        “expires_in”:<seconds-til-expiration>
       }
       ````

5. Perform API requests with access token in header:

       ```
       curl -H "Authorization: Bearer <access-token>"
       http://jobeq.net/api/texts/surveys/iwam/NL
       ```


### Authorization flow

All API requests are executed on behalf of HR user, jobEQ has to know which resources are accessible for client application, so authorization procedure will ask HR user to confirm that application can use his/her data retrieved from jobEQ. 

1. When registering application in jobEQ __redirection uri__ should be provided. HR user will be redirected to that url after authentication is processed in __jobEQ authorization service__. 
2. Before calling jobEQ API client application should redirect user to __jobEQ authorization service__, sending __application ID__ in request, so jobEQ knows where request is coming from. 
3. __jobEQ authorization service__ will perform HR user authentication and will redirect back to __redirection uri__ mentioned in 1. The redirection request will also contain __authorization code__. 
4. Client application software should exchange __authorization code__ and __app secret__ to __access token__.
5. Client application can now perform API request adding __access token__ in request headers.

### Example

Suppose you've created a new application which will be interacting with jobEQ through jobEQ API. Your application is available online on the web-site `http://my-app.com` (it can also be desktop or
mobile app), you will require users of your application to sign in and interact with data received from jobEQ or send data to jobEQ. Below are the list of possible steps needed to make you application work, this may depend on specific implementation and some steps might be ignored.

1. You register your app in jobEQ and receive  `app secret: 1a421e4919b1674defaf1ea063893fe198fe5dd8` and `app ID: BE0176123`, on registration you provide `redirection uri: http://my-app
.com/jobeq_auth`
2. You can place some link or button which will at the end redirect user to jobEQ authorization service: `http://jobeq.net/oauth2/dialog`, on example button with text *"Sign in with jobEQ"*,
in the similar way like web-sites allow to login with social network accounts. You should add your app ID in request, e.g. `http://jobeq.net/oauth2/dialog?client_id=BE0176123&redirect-uri=http://my-app.com/jobeq_auth`
3. jobEQ will perform HR user authentication and redirect to `http://my-app.com/jobeq_auth?code=cf23df2207d99a74fbe169e3eba035e633b65d94` jobEQ will add authorization code to request.
4. After your app has authorization code, it should be exchanged to access token: `http://jobeq
.net/oauth2/access_token?client_id=BE0176123&_code=cf23df2207d99a74fbe169e3eba035e633b65d94&client_secret=1a421e4919b1674defaf1ea063893fe198fe5dd8&redirect_uri=http://my-app.com/jobeq_auth` jobEQ will answer this request with
access token: `{'access_token' : '01234567-89ab-cdef-0123-456789abcdef', “token_type”:<type>,“expires_in”:3600}`
5. Now your app can perform API request adding access token in header: `curl -H "Authorization: Bearer 01234567-89ab-cdef-0123-456789abcdefN" http://jobeq.net/api/texts/surveys/iwam/NL`
