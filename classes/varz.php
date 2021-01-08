<?

// funzioni utili a varz :)

$interesting_env_vars = array(
    "DB_DOVE_STA",
    "DOCKER_HOST_HOSTNAME",
    "DOVE_SONO",
    "ENTRYPOINT8080_TIMESTAMP",
    "FQDN",
    "GOLIARDIA_MYSQL_DB",
    "GOLIARDIA_SITENAME",
    "GOLIARDIA_SITEPATH",
    "GOLIARDIA_GMAIL_USER",
    "GOLIARDIA_DOCKER_VER",
    "REMOTE_ADDR",
    "RAILS_ENV",
    "WEBMASTER_EMAIL",
);
$varz_interesting_values = array(
    #"GOLIARDIA_DOCKER_VER" => $_SERVER['GOLIARDIA_DOCKER_VER'],
    #"GOLIARDIA_DOVESONO" =>   $_SERVER['GOLIARDIA_DOVESONO'] ,
    #"FQDN" => getenv("FQDN"),
    #"TIME_TO_WRITE_THIS_PAGE_MILLIS" => "TODO foobar",
    #"GOLIARDIA_GMAIL_USER" => $_SERVER['GOLIARDIA_GMAIL_USER'],
    "HOSTNAME" => gethostname(),
   # "code-version" => trim(file_get_contents("VERSION")),
    "host-bifido" =>  getHostnameAndDockerHostname(),
    "DB_VER" => getMemozByChiave("db_ver") , 
    "rails-env-func"	=> get_rails_env(),
    "APP_utenti-attivi" => count(explode('$', getApplication("UTENTI_ORA"))) ,
    "goliardia-github-code-version" => trim(file_get_contents("VERSION")), # exec('cat VERSION'), 
);


function get_varz_partial() {
    global $varz_interesting_values, $interesting_env_vars;
    $ret = ""; #  "get_varz_partial()";
    foreach($interesting_env_vars as $k) {
        # invludo questi nei secondi -> cosi posso poi fare SORT alfabetico
        $varz_interesting_values["ENV_$k"] = getenv($k);
    }
    ksort($varz_interesting_values);
    foreach($varz_interesting_values as $key => $value) {
        $ret .= "+ $key: $value\n";
    }
    return $ret;
}

?>