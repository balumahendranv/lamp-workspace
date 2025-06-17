<?php
$user = "user" . rand(1000, 9999);
$port = rand(8000, 8999);
$workspaceDir = "/home/workspace_data/$user";

if (!is_dir($workspaceDir)) {
    if (!mkdir($workspaceDir, 0755, true)) {
        die("❌ Deployment failed: Cannot create workspace");
    }
} else {
    die("❌ Deployment failed: Workspace already exists");
}

file_put_contents("$workspaceDir/index.php", "<?php echo 'Hello from $user!'; ?>");

chown($workspaceDir, 33);
chgrp($workspaceDir, 33);
chmod($workspaceDir, 0755);
chown("$workspaceDir/index.php", 33);
chgrp("$workspaceDir/index.php", 33);
chmod("$workspaceDir/index.php", 0644);

$cmd = "docker run -d -p $port:80 -v $workspaceDir:/var/www/html php:8.2-apache";
$output = shell_exec($cmd);

if ($output) {
    echo "✅ Deployed `$user` on port: $port<br>";
    echo "Visit: <a href='http://localhost:$port' target='_blank'>http://localhost:$port</a>";
} else {
    echo "❌ Deployment failed:<br><pre>$output</pre>";
}
?>
