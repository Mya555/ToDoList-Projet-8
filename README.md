# ToDoList-Projet-8
<a href="http://site5.bella-web.eu/">Online Project</a>
<h1>BileMo-Projet-7</h1>
<p>The project is created for the curcus of OpenClassrooms.</p>
<p>The objective is to improve the quality of the code.
</p>
<p>The application is created with Symfony 3.4.</p>
<p>Tests executed with phpunit.</p>
<h1>How to install the project</h1>
<h4>1 - Download or clone the repository git</h4>
<pre><code>https://github.com/Mya555/ToDoList-Projet-8.git</pre></code>

<h4>2 - Download dependencies :</h4>
<pre><code>composer install</pre></code> 

<h4>3 - Configure the database  :</h4>
<pre><code>In .env configure database and mailer</pre></code> 

<h4>4 - Create database :</h4>
<pre><code>php bin/console doctrine:database:create</pre></code>

<h4>5 - Create schema :</h4>
<pre><code>php bin/console doctrine:schema:update --force</pre></code>

<h4>6 - Load fixtures :</h4>
<pre><code>php bin/console doctrine:fixtures:load</pre></code>

<h4>7 - Run the server :</h4>
<pre><code>PHP -S localhost:8080</pre></code>

<h4> Code coverage :</h4>
<pre><code>http://localhost/test-coverage/index.html</pre></code>

<h4> Execute phpunit test :</h4>
<pre><code>"./vendor/bin/phpunit</pre></code>

<h1>Existing users</h1>
<table>
    <thead>
      <tr>
          <th>LOGIN</th>
          <th>PASSWORD</th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td>anonyme</td>
            <td>password</td>
        </tr>
        <tr>
            <td>admin</td>
            <td>password</td>
        </tr>
        <tr>
            <td>user</td>
            <td>password</td>
        </tr>
    </tbody>
</table>


