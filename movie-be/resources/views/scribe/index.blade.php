<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.8.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.8.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-auth" class="tocify-header">
                <li class="tocify-item level-1" data-unique="auth">
                    <a href="#auth">Auth</a>
                </li>
                                    <ul id="tocify-subheader-auth" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="auth-POSTapi-auth-register">
                                <a href="#auth-POSTapi-auth-register">Register a new user</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-auth-login">
                                <a href="#auth-POSTapi-auth-login">Log in</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-GETapi-auth-me">
                                <a href="#auth-GETapi-auth-me">Get the authenticated user</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-auth-logout">
                                <a href="#auth-POSTapi-auth-logout">Log out</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-email-verification" class="tocify-header">
                <li class="tocify-item level-1" data-unique="email-verification">
                    <a href="#email-verification">Email verification</a>
                </li>
                                    <ul id="tocify-subheader-email-verification" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="email-verification-POSTapi-auth-email-verification-notification">
                                <a href="#email-verification-POSTapi-auth-email-verification-notification">Send verification email</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="email-verification-GETapi-auth-email-verify--id---hash-">
                                <a href="#email-verification-GETapi-auth-email-verify--id---hash-">Verify email address</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-health_check">
                                <a href="#endpoints-GETapi-health_check">GET api/health_check</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-favorites" class="tocify-header">
                <li class="tocify-item level-1" data-unique="favorites">
                    <a href="#favorites">Favorites</a>
                </li>
                                    <ul id="tocify-subheader-favorites" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="favorites-GETapi-favorites">
                                <a href="#favorites-GETapi-favorites">List favourites</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="favorites-POSTapi-favorites">
                                <a href="#favorites-POSTapi-favorites">Add a movie to favourites</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="favorites-DELETEapi-favorites--imdbId-">
                                <a href="#favorites-DELETEapi-favorites--imdbId-">Remove a movie from favourites</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-movies" class="tocify-header">
                <li class="tocify-item level-1" data-unique="movies">
                    <a href="#movies">Movies</a>
                </li>
                                    <ul id="tocify-subheader-movies" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="movies-GETapi-movies-search">
                                <a href="#movies-GETapi-movies-search">Search movies</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="movies-GETapi-movies">
                                <a href="#movies-GETapi-movies">List recent movies</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="movies-GETapi-movies--imdbId-">
                                <a href="#movies-GETapi-movies--imdbId-">Show movie details</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: February 25, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>First call the <b>Login</b> endpoint to obtain a token. Then paste it here in the format <code>Bearer your-token-here</code> to use the Try It Out feature.</p>

        <h1 id="auth">Auth</h1>

    <p>Endpoints for registering, logging in and managing the authenticated user.</p>

                                <h2 id="auth-POSTapi-auth-register">Register a new user</h2>

<p>
</p>

<p>Create a new user account and return the created user.</p>

<span id="example-requests-POSTapi-auth-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/auth/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Jane Doe\",
    \"email\": \"jane@example.com\",
    \"password\": \"password123\",
    \"password_confirmation\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/auth/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123",
    "password_confirmation": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-register">
</span>
<span id="execution-results-POSTapi-auth-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-register" data-method="POST"
      data-path="api/auth/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-register"
                    onclick="tryItOut('POSTapi-auth-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-register"
                    onclick="cancelTryOut('POSTapi-auth-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-auth-register"
               value="Jane Doe"
               data-component="body">
    <br>
<p>The name of the user. Example: <code>Jane Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-register"
               value="jane@example.com"
               data-component="body">
    <br>
<p>The email address of the user. Must be unique. Example: <code>jane@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-register"
               value="password123"
               data-component="body">
    <br>
<p>The password for the account (min 8 characters). Example: <code>password123</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-auth-register"
               value="password123"
               data-component="body">
    <br>
<p>Must match the password field. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-auth-login">Log in</h2>

<p>
</p>

<p>Authenticate an existing user and return an access token.</p>

<span id="example-requests-POSTapi-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"jane@example.com\",
    \"password\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "jane@example.com",
    "password": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-login">
</span>
<span id="execution-results-POSTapi-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-login" data-method="POST"
      data-path="api/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-login"
                    onclick="tryItOut('POSTapi-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-login"
                    onclick="cancelTryOut('POSTapi-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-login"
               value="jane@example.com"
               data-component="body">
    <br>
<p>The email address of the user. Example: <code>jane@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-login"
               value="password123"
               data-component="body">
    <br>
<p>The user password. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="auth-GETapi-auth-me">Get the authenticated user</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Return the currently authenticated user's details.</p>

<span id="example-requests-GETapi-auth-me">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/auth/me" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/auth/me"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-me">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-me" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-me"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-me" data-method="GET"
      data-path="api/auth/me"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-me', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-me"
                    onclick="tryItOut('GETapi-auth-me');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-me"
                    onclick="cancelTryOut('GETapi-auth-me');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-me"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/me</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-auth-me"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="auth-POSTapi-auth-logout">Log out</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Revoke the current access token and log the user out.</p>

<span id="example-requests-POSTapi-auth-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/auth/logout" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/auth/logout"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-logout">
</span>
<span id="execution-results-POSTapi-auth-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-logout" data-method="POST"
      data-path="api/auth/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-logout"
                    onclick="tryItOut('POSTapi-auth-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-logout"
                    onclick="cancelTryOut('POSTapi-auth-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-auth-logout"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="email-verification">Email verification</h1>

    <p>Endpoints for sending and handling email verification links.</p>

                                <h2 id="email-verification-POSTapi-auth-email-verification-notification">Send verification email</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Send an email verification link to the authenticated user.</p>

<span id="example-requests-POSTapi-auth-email-verification-notification">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/auth/email/verification-notification" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/auth/email/verification-notification"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-email-verification-notification">
</span>
<span id="execution-results-POSTapi-auth-email-verification-notification" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-email-verification-notification"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-email-verification-notification"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-email-verification-notification" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-email-verification-notification">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-email-verification-notification" data-method="POST"
      data-path="api/auth/email/verification-notification"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-email-verification-notification', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-email-verification-notification"
                    onclick="tryItOut('POSTapi-auth-email-verification-notification');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-email-verification-notification"
                    onclick="cancelTryOut('POSTapi-auth-email-verification-notification');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-email-verification-notification"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/email/verification-notification</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-auth-email-verification-notification"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-email-verification-notification"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-email-verification-notification"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="email-verification-GETapi-auth-email-verify--id---hash-">Verify email address</h2>

<p>
</p>

<p>Mark a user's email address as verified using the link parameters.</p>

<span id="example-requests-GETapi-auth-email-verify--id---hash-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/auth/email/verify/1/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/auth/email/verify/1/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-email-verify--id---hash-">
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invalid signature.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-email-verify--id---hash-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-email-verify--id---hash-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-email-verify--id---hash-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-email-verify--id---hash-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-email-verify--id---hash-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-email-verify--id---hash-" data-method="GET"
      data-path="api/auth/email/verify/{id}/{hash}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-email-verify--id---hash-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-email-verify--id---hash-"
                    onclick="tryItOut('GETapi-auth-email-verify--id---hash-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-email-verify--id---hash-"
                    onclick="cancelTryOut('GETapi-auth-email-verify--id---hash-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-email-verify--id---hash-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/email/verify/{id}/{hash}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-email-verify--id---hash-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-email-verify--id---hash-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-auth-email-verify--id---hash-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user whose email is being verified. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>hash</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="hash"                data-endpoint="GETapi-auth-email-verify--id---hash-"
               value="architecto"
               data-component="url">
    <br>
<p>The verification hash from the email link. Example: <code>architecto</code></p>
            </div>
                    </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-health_check">GET api/health_check</h2>

<p>
</p>



<span id="example-requests-GETapi-health_check">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/health_check" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/health_check"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-health_check">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-health_check" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-health_check"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-health_check"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-health_check" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-health_check">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-health_check" data-method="GET"
      data-path="api/health_check"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-health_check', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-health_check"
                    onclick="tryItOut('GETapi-health_check');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-health_check"
                    onclick="cancelTryOut('GETapi-health_check');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-health_check"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/health_check</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-health_check"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-health_check"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="favorites">Favorites</h1>

    <p>Endpoints for managing a user's favourite movies.</p>

                                <h2 id="favorites-GETapi-favorites">List favourites</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of the authenticated user's favourite movies.</p>

<span id="example-requests-GETapi-favorites">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/favorites?per_page=20" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/favorites"
);

const params = {
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-favorites">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-favorites" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-favorites"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-favorites"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-favorites" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-favorites">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-favorites" data-method="GET"
      data-path="api/favorites"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-favorites', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-favorites"
                    onclick="tryItOut('GETapi-favorites');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-favorites"
                    onclick="cancelTryOut('GETapi-favorites');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-favorites"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/favorites</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-favorites"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-favorites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-favorites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-favorites"
               value="20"
               data-component="query">
    <br>
<p>The number of favourites per page. Default: 10. Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="favorites-POSTapi-favorites">Add a movie to favourites</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Mark a movie as a favourite for the authenticated user.</p>

<span id="example-requests-POSTapi-favorites">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/favorites" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"imdb_id\": \"tt0133093\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/favorites"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "imdb_id": "tt0133093"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-favorites">
</span>
<span id="execution-results-POSTapi-favorites" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-favorites"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-favorites"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-favorites" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-favorites">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-favorites" data-method="POST"
      data-path="api/favorites"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-favorites', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-favorites"
                    onclick="tryItOut('POSTapi-favorites');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-favorites"
                    onclick="cancelTryOut('POSTapi-favorites');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-favorites"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/favorites</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-favorites"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-favorites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-favorites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>imdb_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="imdb_id"                data-endpoint="POSTapi-favorites"
               value="tt0133093"
               data-component="body">
    <br>
<p>The IMDb ID of the movie to favourite. Example: <code>tt0133093</code></p>
        </div>
        </form>

                    <h2 id="favorites-DELETEapi-favorites--imdbId-">Remove a movie from favourites</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove a movie from the authenticated user's favourites.</p>

<span id="example-requests-DELETEapi-favorites--imdbId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost:8000/api/favorites/tt0133093" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/favorites/tt0133093"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-favorites--imdbId-">
</span>
<span id="execution-results-DELETEapi-favorites--imdbId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-favorites--imdbId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-favorites--imdbId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-favorites--imdbId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-favorites--imdbId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-favorites--imdbId-" data-method="DELETE"
      data-path="api/favorites/{imdbId}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-favorites--imdbId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-favorites--imdbId-"
                    onclick="tryItOut('DELETEapi-favorites--imdbId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-favorites--imdbId-"
                    onclick="cancelTryOut('DELETEapi-favorites--imdbId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-favorites--imdbId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/favorites/{imdbId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-favorites--imdbId-"
               value="Bearer {YOUR_AUTH_KEY}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_KEY}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-favorites--imdbId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-favorites--imdbId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>imdbId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="imdbId"                data-endpoint="DELETEapi-favorites--imdbId-"
               value="tt0133093"
               data-component="url">
    <br>
<p>The IMDb ID of the movie to remove. Example: <code>tt0133093</code></p>
            </div>
                    </form>

                <h1 id="movies">Movies</h1>

    <p>Endpoints for searching and retrieving movies.</p>

                                <h2 id="movies-GETapi-movies-search">Search movies</h2>

<p>
</p>

<p>Search for movies using the OMDb API and return matched titles.</p>

<span id="example-requests-GETapi-movies-search">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/movies/search?q=The+Matrix&amp;page=2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"q\": \"bngzmiyvdljnikhw\",
    \"page\": 7
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/movies/search"
);

const params = {
    "q": "The Matrix",
    "page": "2",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "q": "bngzmiyvdljnikhw",
    "page": 7
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-movies-search">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;meta&quot;: {
        &quot;total&quot;: 0,
        &quot;current_page&quot;: 7,
        &quot;per_page&quot;: 0,
        &quot;source&quot;: &quot;omdb&quot;,
        &quot;omdb_response&quot;: &quot;False&quot;,
        &quot;omdb_error&quot;: &quot;Movie not found!&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-movies-search" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-movies-search"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-movies-search"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-movies-search" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-movies-search">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-movies-search" data-method="GET"
      data-path="api/movies/search"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-movies-search', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-movies-search"
                    onclick="tryItOut('GETapi-movies-search');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-movies-search"
                    onclick="cancelTryOut('GETapi-movies-search');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-movies-search"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/movies/search</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-movies-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-movies-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>q</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="q"                data-endpoint="GETapi-movies-search"
               value="The Matrix"
               data-component="query">
    <br>
<p>The search term (title or keyword). Example: <code>The Matrix</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-movies-search"
               value="2"
               data-component="query">
    <br>
<p>The page of results to view. Minimum: 1. Example: <code>2</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>q</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="q"                data-endpoint="GETapi-movies-search"
               value="bngzmiyvdljnikhw"
               data-component="body">
    <br>
<p>Must be at least 1 character. Example: <code>bngzmiyvdljnikhw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-movies-search"
               value="7"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>7</code></p>
        </div>
        </form>

                    <h2 id="movies-GETapi-movies">List recent movies</h2>

<p>
</p>

<p>Returns a list of the most recently stored movies.</p>

<span id="example-requests-GETapi-movies">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/movies" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/movies"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-movies">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;imdb_id&quot;: &quot;tt0791188&quot;,
            &quot;title&quot;: &quot;Naruto the Movie 2: Legend of the Stone of Gelel&quot;,
            &quot;year&quot;: &quot;2005&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BMDk5N2Y2ZGUtZGY5YS00YjgyLWEzOGItMjgwZWJjYmJiZmViXkEyXkFqcGc@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2005&quot;,
                &quot;Title&quot;: &quot;Naruto the Movie 2: Legend of the Stone of Gelel&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BMDk5N2Y2ZGUtZGY5YS00YjgyLWEzOGItMjgwZWJjYmJiZmViXkEyXkFqcGc@._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt0791188&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt0409591&quot;,
            &quot;title&quot;: &quot;Naruto&quot;,
            &quot;year&quot;: &quot;2002&ndash;2007&quot;,
            &quot;type&quot;: &quot;series&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BZTNjOWI0ZTAtOGY1OS00ZGU0LWEyOWYtMjhkYjdlYmVjMDk2XkEyXkFqcGc@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;series&quot;,
                &quot;Year&quot;: &quot;2002&ndash;2007&quot;,
                &quot;Title&quot;: &quot;Naruto&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BZTNjOWI0ZTAtOGY1OS00ZGU0LWEyOWYtMjhkYjdlYmVjMDk2XkEyXkFqcGc@._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt0409591&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt3717532&quot;,
            &quot;title&quot;: &quot;The Last: Naruto the Movie&quot;,
            &quot;year&quot;: &quot;2014&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BMjk1NzA4Njg4Ml5BMl5BanBnXkFtZTgwMDgxODQ5MzE@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2014&quot;,
                &quot;Title&quot;: &quot;The Last: Naruto the Movie&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BMjk1NzA4Njg4Ml5BMl5BanBnXkFtZTgwMDgxODQ5MzE@._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt3717532&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt0476680&quot;,
            &quot;title&quot;: &quot;Naruto the Movie: Ninja Clash in the Land of Snow&quot;,
            &quot;year&quot;: &quot;2004&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BYzZiNmI3MWYtYzA4YS00YjE4LWFhMzQtYzQ3MTE2MTcyOGM1XkEyXkFqcGc@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;DVD&quot;: &quot;N/A&quot;,
                &quot;Plot&quot;: &quot;Naruto Uzumaki the ninja-in-training knuckle-headed and his team are sent on a mission to guard Yukie Fujikaze, a popular actress starring the hit movie \&quot;The Adventures of Princess Gale.\&quot; The crew is heading toward the Land of Snow, a land forever covered in snow, to shoot the final scenes of the film. When Yukie refuses to go and escapes from the set, she is brought back by force by Naruto and his teammates. But little do they know there are three rouge Snow Ninja lying in wait with a sinister purpose that forces Yukie to make a crucial decision and face her hidden past.&quot;,
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2004&quot;,
                &quot;Genre&quot;: &quot;Animation, Action, Adventure&quot;,
                &quot;Rated&quot;: &quot;TV-14&quot;,
                &quot;Title&quot;: &quot;Naruto the Movie: Ninja Clash in the Land of Snow&quot;,
                &quot;Actors&quot;: &quot;Junko Takeuchi, Chie Nakamura, Noriaki Sugiyama&quot;,
                &quot;Awards&quot;: &quot;N/A&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BYzZiNmI3MWYtYzA4YS00YjE4LWFhMzQtYzQ3MTE2MTcyOGM1XkEyXkFqcGc@._V1_SX300.jpg&quot;,
                &quot;Writer&quot;: &quot;Masashi Kishimoto, Katsuyuki Sumizawa, Ardwight Chamberlain&quot;,
                &quot;imdbID&quot;: &quot;tt0476680&quot;,
                &quot;Country&quot;: &quot;Japan&quot;,
                &quot;Ratings&quot;: [
                    {
                        &quot;Value&quot;: &quot;6.6/10&quot;,
                        &quot;Source&quot;: &quot;Internet Movie Database&quot;
                    }
                ],
                &quot;Runtime&quot;: &quot;82 min&quot;,
                &quot;Website&quot;: &quot;N/A&quot;,
                &quot;Director&quot;: &quot;Tensai Okamura&quot;,
                &quot;Language&quot;: &quot;Japanese&quot;,
                &quot;Released&quot;: &quot;06 Jun 2007&quot;,
                &quot;Response&quot;: &quot;True&quot;,
                &quot;BoxOffice&quot;: &quot;N/A&quot;,
                &quot;Metascore&quot;: &quot;N/A&quot;,
                &quot;imdbVotes&quot;: &quot;9,254&quot;,
                &quot;Production&quot;: &quot;N/A&quot;,
                &quot;imdbRating&quot;: &quot;6.6&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt1999167&quot;,
            &quot;title&quot;: &quot;Naruto Shippuden the Movie: Blood Prison&quot;,
            &quot;year&quot;: &quot;2011&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BZTgwZDkyODktYjk0My00NTVhLWIxMmQtMGY4ODYzMTlhYmE5XkEyXkFqcGc@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;DVD&quot;: &quot;N/A&quot;,
                &quot;Plot&quot;: &quot;Naruto&#039;s battle to reclaim his honor begins! Naruto is convicted of a serious crime he didn&#039;t commit and is sent to the inescapable prison, Hozuki Castle. The warden, Mui, quickly seals away Naruto&#039;s chakra to prevent him from rebelling. Refusing to give up, Naruto plans his escape while also befriending his fellow inmates Ryuzetsu and Maroi. But he can&#039;t help but wonder what their ulterior motives are...&quot;,
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2011&quot;,
                &quot;Genre&quot;: &quot;Animation, Action, Mystery&quot;,
                &quot;Rated&quot;: &quot;TV-14&quot;,
                &quot;Title&quot;: &quot;Naruto Shippuden the Movie: Blood Prison&quot;,
                &quot;Actors&quot;: &quot;Junko Takeuchi, Chie Nakamura, Rikiya Koyama&quot;,
                &quot;Awards&quot;: &quot;1 nomination total&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BZTgwZDkyODktYjk0My00NTVhLWIxMmQtMGY4ODYzMTlhYmE5XkEyXkFqcGc@._V1_SX300.jpg&quot;,
                &quot;Writer&quot;: &quot;Ardwight Chamberlain, Akira Higashiyama, Masashi Kishimoto&quot;,
                &quot;imdbID&quot;: &quot;tt1999167&quot;,
                &quot;Country&quot;: &quot;Japan&quot;,
                &quot;Ratings&quot;: [
                    {
                        &quot;Value&quot;: &quot;7.1/10&quot;,
                        &quot;Source&quot;: &quot;Internet Movie Database&quot;
                    }
                ],
                &quot;Runtime&quot;: &quot;108 min&quot;,
                &quot;Website&quot;: &quot;N/A&quot;,
                &quot;Director&quot;: &quot;Masahiko Murata&quot;,
                &quot;Language&quot;: &quot;Japanese&quot;,
                &quot;Released&quot;: &quot;18 Feb 2014&quot;,
                &quot;Response&quot;: &quot;True&quot;,
                &quot;BoxOffice&quot;: &quot;N/A&quot;,
                &quot;Metascore&quot;: &quot;N/A&quot;,
                &quot;imdbVotes&quot;: &quot;6,638&quot;,
                &quot;Production&quot;: &quot;N/A&quot;,
                &quot;imdbRating&quot;: &quot;7.1&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt2290828&quot;,
            &quot;title&quot;: &quot;Road to Ninja - Naruto the Movie&quot;,
            &quot;year&quot;: &quot;2012&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BMTQ5MTcyNDYwMV5BMl5BanBnXkFtZTgwNzMzNzc0MjE@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2012&quot;,
                &quot;Title&quot;: &quot;Road to Ninja - Naruto the Movie&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BMTQ5MTcyNDYwMV5BMl5BanBnXkFtZTgwNzMzNzc0MjE@._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt2290828&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt1160524&quot;,
            &quot;title&quot;: &quot;Naruto Shippuden: The Movie - Bonds&quot;,
            &quot;year&quot;: &quot;2008&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BNTE2ODAyNTkxNl5BMl5BanBnXkFtZTgwNTAzMjA2MDE@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2008&quot;,
                &quot;Title&quot;: &quot;Naruto Shippuden: The Movie - Bonds&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BNTE2ODAyNTkxNl5BMl5BanBnXkFtZTgwNTAzMjA2MDE@._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt1160524&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt9635524&quot;,
            &quot;title&quot;: &quot;Mother Teresa 123 Springhill Avenue&quot;,
            &quot;year&quot;: &quot;2011&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;N/A&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2011&quot;,
                &quot;Title&quot;: &quot;Mother Teresa 123 Springhill Avenue&quot;,
                &quot;Poster&quot;: &quot;N/A&quot;,
                &quot;imdbID&quot;: &quot;tt9635524&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt2331554&quot;,
            &quot;title&quot;: &quot;Inseparable Souls: Fathers, Sons, and the Crash of JAL 123&quot;,
            &quot;year&quot;: &quot;2012&ndash;&quot;,
            &quot;type&quot;: &quot;series&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BYTcxZDU1NTYtMDY4Zi00NGU5LWE5OGMtNWRmMzZkOTI2OTU0XkEyXkFqcGdeQXVyMjI1Mjk5ODQ@._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;series&quot;,
                &quot;Year&quot;: &quot;2012&ndash;&quot;,
                &quot;Title&quot;: &quot;Inseparable Souls: Fathers, Sons, and the Crash of JAL 123&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BYTcxZDU1NTYtMDY4Zi00NGU5LWE5OGMtNWRmMzZkOTI2OTU0XkEyXkFqcGdeQXVyMjI1Mjk5ODQ@._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt2331554&quot;
            }
        },
        {
            &quot;imdb_id&quot;: &quot;tt13490412&quot;,
            &quot;title&quot;: &quot;Phome 123&quot;,
            &quot;year&quot;: &quot;2018&quot;,
            &quot;type&quot;: &quot;movie&quot;,
            &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BYTYyN2M4YmQtNzQ3Yy00MWU4LWE4M2UtOTg2MzZhZDdhYjAzXkEyXkFqcGdeQXVyMTI2NDAxODkw._V1_SX300.jpg&quot;,
            &quot;is_favorited&quot;: false,
            &quot;details&quot;: {
                &quot;Type&quot;: &quot;movie&quot;,
                &quot;Year&quot;: &quot;2018&quot;,
                &quot;Title&quot;: &quot;Phome 123&quot;,
                &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BYTYyN2M4YmQtNzQ3Yy00MWU4LWE4M2UtOTg2MzZhZDdhYjAzXkEyXkFqcGdeQXVyMTI2NDAxODkw._V1_SX300.jpg&quot;,
                &quot;imdbID&quot;: &quot;tt13490412&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-movies" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-movies"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-movies"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-movies" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-movies">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-movies" data-method="GET"
      data-path="api/movies"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-movies', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-movies"
                    onclick="tryItOut('GETapi-movies');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-movies"
                    onclick="cancelTryOut('GETapi-movies');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-movies"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/movies</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-movies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-movies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="movies-GETapi-movies--imdbId-">Show movie details</h2>

<p>
</p>

<p>Retrieve full details for a movie by its IMDb ID.</p>

<span id="example-requests-GETapi-movies--imdbId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/movies/tt0133093" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/movies/tt0133093"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-movies--imdbId-">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;imdb_id&quot;: &quot;tt0133093&quot;,
        &quot;title&quot;: &quot;The Matrix&quot;,
        &quot;year&quot;: &quot;1999&quot;,
        &quot;type&quot;: &quot;movie&quot;,
        &quot;poster_url&quot;: &quot;https://m.media-amazon.com/images/M/MV5BN2NmN2VhMTQtMDNiOS00NDlhLTliMjgtODE2ZTY0ODQyNDRhXkEyXkFqcGc@._V1_SX300.jpg&quot;,
        &quot;is_favorited&quot;: false,
        &quot;details&quot;: {
            &quot;Title&quot;: &quot;The Matrix&quot;,
            &quot;Year&quot;: &quot;1999&quot;,
            &quot;Rated&quot;: &quot;R&quot;,
            &quot;Released&quot;: &quot;31 Mar 1999&quot;,
            &quot;Runtime&quot;: &quot;136 min&quot;,
            &quot;Genre&quot;: &quot;Action, Sci-Fi&quot;,
            &quot;Director&quot;: &quot;Lana Wachowski, Lilly Wachowski&quot;,
            &quot;Writer&quot;: &quot;Lilly Wachowski, Lana Wachowski&quot;,
            &quot;Actors&quot;: &quot;Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss&quot;,
            &quot;Plot&quot;: &quot;Thomas A. Anderson is a man living two lives. By day he is an average computer programmer and by night a hacker known as Neo. Neo has always questioned his reality, but the truth is far beyond his imagination. Neo finds himself targeted by the police when he is contacted by Morpheus, a legendary computer hacker branded a terrorist by the government. As a rebel against the machines, Neo must confront the agents: super-powerful computer programs devoted to stopping Neo and the entire human rebellion.&quot;,
            &quot;Language&quot;: &quot;English&quot;,
            &quot;Country&quot;: &quot;United States, Australia&quot;,
            &quot;Awards&quot;: &quot;Won 4 Oscars. 42 wins &amp; 52 nominations total&quot;,
            &quot;Poster&quot;: &quot;https://m.media-amazon.com/images/M/MV5BN2NmN2VhMTQtMDNiOS00NDlhLTliMjgtODE2ZTY0ODQyNDRhXkEyXkFqcGc@._V1_SX300.jpg&quot;,
            &quot;Ratings&quot;: [
                {
                    &quot;Source&quot;: &quot;Internet Movie Database&quot;,
                    &quot;Value&quot;: &quot;8.7/10&quot;
                },
                {
                    &quot;Source&quot;: &quot;Rotten Tomatoes&quot;,
                    &quot;Value&quot;: &quot;83%&quot;
                },
                {
                    &quot;Source&quot;: &quot;Metacritic&quot;,
                    &quot;Value&quot;: &quot;73/100&quot;
                }
            ],
            &quot;Metascore&quot;: &quot;73&quot;,
            &quot;imdbRating&quot;: &quot;8.7&quot;,
            &quot;imdbVotes&quot;: &quot;2,228,203&quot;,
            &quot;imdbID&quot;: &quot;tt0133093&quot;,
            &quot;Type&quot;: &quot;movie&quot;,
            &quot;DVD&quot;: &quot;N/A&quot;,
            &quot;BoxOffice&quot;: &quot;$177,559,005&quot;,
            &quot;Production&quot;: &quot;N/A&quot;,
            &quot;Website&quot;: &quot;N/A&quot;,
            &quot;Response&quot;: &quot;True&quot;
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-movies--imdbId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-movies--imdbId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-movies--imdbId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-movies--imdbId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-movies--imdbId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-movies--imdbId-" data-method="GET"
      data-path="api/movies/{imdbId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-movies--imdbId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-movies--imdbId-"
                    onclick="tryItOut('GETapi-movies--imdbId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-movies--imdbId-"
                    onclick="cancelTryOut('GETapi-movies--imdbId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-movies--imdbId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/movies/{imdbId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-movies--imdbId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-movies--imdbId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>imdbId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="imdbId"                data-endpoint="GETapi-movies--imdbId-"
               value="tt0133093"
               data-component="url">
    <br>
<p>The IMDb ID of the movie. Example: <code>tt0133093</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
