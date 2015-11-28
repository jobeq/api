## jobEQ API authorization

Authorization is required to use [jobEQ API](http://www.jobeq.info/api/). Application should provide valid access token with every API request. Authorization is based on oAuth2 protocol, "authorization code" scenario is used. Note that in order to use jobEQ API application also needs to receive a secret key and ID from jobEQ, please mail jobEQ to register your app. 

### How to start using jobEQ API ?

1. Register your client application and receive __secret key__ and __application ID__, by sending email to jobEQ.
2. Authorize application access through __jobEQ authorization service__. 
3. Call API functions through http adding __access token__ to each request.

### Authorization flow

All API requests are executed on behalf of HR user, jobEQ has to know which resources are accessible for client application, so authorization procedure will ask HR user to confirm that application can use his/her data retrieved from jobEQ. 

1. When registering application in jobEQ __redirection url__ should be provided. HR user will be redirected to that url after authentication is processed in __jobEQ authorization service__. 
2. Before calling jobEQ API client application should redirect user to __jobEQ authorization service__, sending __application ID__ in request, so jobEQ knows where request is coming from. 
3. __jobEQ authorization service__ will perform HR user authentication and will redirect back to __redirection url__ mentioned in 1. The redirection request will also contain __authorization code__. 
4. Client application software should exchange __authorization code__ and __secret key__ to __access token__. 
5. Client application can now perform API request adding __access token__ in request headers.

### Example

Suppose you've created a new application which will be interacting with jobEQ through jobEQ API. Your application is available online on the web-site __http://my-app.com__ (it can also be desktop or mobile app), you will require users of your application to sign in and interact with data received from jobEQ or send data to jobEQ. Below are the list of possible steps needed to make you application work, this may depend on specific implementation and some steps might be ignored.

1. You register your app in jobEQ and recieve  secret key: "'n *.JfgSZ-GS!K<]_ XI)xBEaRpM>(Y o:7<9ddsv15Q@7vR>!wf^+!WM!E>Db(>'"  and app ID: "BE0176123", on registration you provide redirection url: __http://my-app.com/jobeq_auth__
2. You can place some link or button which will at the end redirect user to jobEQ authorization service: __http://jobeq.net/oauth2/dialog__, on example button with text *"Sign in with jobEQ"*, in the similar way like web-sites allow to login with social network accounts. You should add your app ID in request, e.g. __http://jobeq.net/oauth2/dialog?app_id=BE0176123__
3. jobEQ will perform HR user authentication and redirect to __http://my-app.com/jobeq_auth?auth_code=cf23df2207d99a74fbe169e3eba035e633b65d94__ jobEQ will add authorization code to request.
4. After your app has authorization code, it should be exchanged to access token: __http://jobeq.net/oauth2/access_token?app_id=BE0176123&auth_code=cf23df2207d99a74fbe169e3eba035e633b65d94&app_secret=.JfgSZ-GS!K<]_ XI)xBEaRpM>(Y o:7<9ddsv15Q@7vR>!wf^+!WM!E>Db(>'__ jobEQ will answer this request with access token: {'access_token' : '01234567-89ab-cdef-0123-456789abcdef'}
5. Now your app can perform API request adding access token in header: `curl -H "Authorization: Bearer 01234567-89ab-cdef-0123-456789abcdefN" http://jobeq.net/api/texts/surveys/iwam/NL`
