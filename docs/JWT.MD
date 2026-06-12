#### JWT (`JSON WEB TOKEN`)
- Is used for auth for securely transmitting information as a JSON Object. It is self contained and digitally signed. It use for auth without creating a session the server which is stateless.


#### Install Library
```
composer require php-open-source-saver/jwt-auth
```

#### Publish Vendor for customization
```
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

#### Generate JWT Sing or secret key
```
php artisan jwt:secret
```

### Sample JWT
```
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2xvZ2luIiwiaWF0IjoxNzgwNTYwMDQ2LCJleHAiOjE3ODA1NjM2NDYsIm5iZiI6MTc4MDU2MDA0NiwianRpIjoiTXc5TWtEQlhSYWttTHUwNSIsInN1YiI6IjciLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.
Ode9lqpsPzOG5nrOltrvYzfOqpjWewQMUIJ5XEDLJQw"
```

### JWT is separated 3 parts with dots

# Header
```
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.

# if this is decode with base64 it will be a simple json what type of the token is encrypted
#sample
{
    "typ": "JWT",
    "alg": "HS256" // algorithm used to sign the token (HMAC SHA256)
}
```

# Payload
```
eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2xvZ2luIiwiaWF0IjoxNzgwNTYwMDQ2LCJleHAiOjE3ODA1NjM2NDYsIm5iZiI6MTc4MDU2MDA0NiwianRpIjoiTXc5TWtEQlhSYWttTHUwNSIsInN1YiI6IjciLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.

# Payload is the main context of the jwt about the token of the auth user and the token lifecycle
#sample decoded
{
    "iss": "http://localhost:8000/api/v1/login", // issuer (Who created the token)
    "iat": 1780559847,                           // issued At (Timestamp when created)
    "exp": 1780563447,                           // expiration time (Timestamp when it dies)
    "nbf": 1780559847,                           // not Before (Valid immediately)
    "jti": "vvpPX7B3Qv0io4DK",                   // unique ID for this specific token
    "sub": "7",                                  // subject (Your User ID in the database is 7)
    "prv": "23bd5c8949f600adb39e701c400872db7a5976f7" // internal package provider hash
}
```

# Signature
```
Ode9lqpsPzOG5nrOltrvYzfOqpjWewQMUIJ5XEDLJQw

# the signature is the hash combination of the header, payload and the jwt_secret in the .env
# the code of creating sample

Signature = HMAC-SHA256(Base64Url(Header) + "." + Base64Url(Payload), JWT_SECRET);
```

### Script to auto save in postman jwt token during auth login
```
let res = pm.response.json();
if(res.access_token) {
    pm.environment.set("token", res.access_token);
}
```