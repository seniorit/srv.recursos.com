#!/bin/bash
# ----------------------------------------------------
# CONFIGURACIÓN DE LARAVEL EN FEDORA (SELinux & Permisos)
# Este script establece permisos POSIX y SELinux persistentes
# para el desarrollo con Laravel en entornos Fedora/RHEL.
#
# Uso: chmod +x setup_laravel-permission.sh && ./setup_laravel-permission.sh
# ----------------------------------------------------

# ⚙️ CONFIGURACIÓN PERSONALIZABLE
# Asegúrate de que estos valores reflejen tu sistema:

USER="ricardo-dev"
DIR_PROJECT="/home/ricardo-dev/Proyectos/PHP/srv.recursos.com"
GROUP="apache"
LOG_FILE="$DIR_PROJECT/storage/logs/laravel.log"

echo "🚀 Iniciando configuración de permisos para $DIR_PROJECT"

# 1. 🔥 Firewall
# ----------------------------------------
sudo firewall-cmd --add-service=http --permanent 2>/dev/null || true
sudo firewall-cmd --reload 2>/dev/null || true
echo "✅ Firewall: HTTP habilitado"

# 2. 👥 Usuario y Grupo
# ----------------------------------------
sudo usermod -a -G $GROUP $USER 2>/dev/null || true
echo "✅ Usuario $USER en grupo $GROUP"

# 3. 📁 Permisos POSIX Base
# ----------------------------------------
# Otorgar propiedad al usuario/grupo de desarrollo
sudo chown -R $USER:$GROUP $DIR_PROJECT

# Permisos base: 775 para directorios, 664 para archivos
sudo find $DIR_PROJECT -type d -exec chmod 775 {} \;
sudo find $DIR_PROJECT -type f -exec chmod 664 {} \;
echo "✅ Propietario y permisos base (POSIX)"

# 4. 📂 Carpetas Críticas (Storage y Cache)
# ----------------------------------------
sudo chown -R $USER:$GROUP "$DIR_PROJECT/storage" "$DIR_PROJECT/bootstrap/cache"
sudo chmod -R ug+rwX "$DIR_PROJECT/storage" "$DIR_PROJECT/bootstrap/cache"
echo "✅ storage y cache listos (POSIX)"


# 6. 🔐 .htaccess para bloquear PHP en public/storage
# ----------------------------------------
HTACCESS="$DIR_PROJECT/public/storage/.htaccess"
cat > "$HTACCESS" << 'EOF'
# 🛑 NO EJECUTAR PHP AQUÍ
<Files "*.php">
    Require all denied
</Files>
EOF
sudo chown $USER:$GROUP "$HTACCESS"
sudo chmod 644 "$HTACCESS"
echo "✅ .htaccess creado: PHP bloqueado en public/storage"

# 7. 🛡️ ACLs (para permitir que el grupo 'apache' escriba)
# ----------------------------------------
sudo setfacl -m u:$GROUP:x "/home/$USER" "/home/$USER/Proyectos" "/home/$USER/Proyectos/PHP"
echo "✅ ACLs: apache tiene acceso controlado"

# 8. 🔒 SELinux (¡CORRECCIÓN PERMANENTE!)
# ----------------------------------------
echo "🔄 Configurando SELinux (Persistente)..."

# a) Restablecer reglas antiguas y definir reglas de contenido (solo lectura)
# Usamos 'semanage fcontext -a' para crear reglas que sobreviven a los reinicios.
# Definimos el contexto de solo lectura (httpd_sys_content_t) para todo el proyecto.
sudo semanage fcontext -a -t httpd_sys_content_t "$DIR_PROJECT(/.*)?" 2>/dev/null || true

# b) Definir reglas de lectura/escritura (RW)
# Esto es CRÍTICO. Define el contexto de lectura/escritura (httpd_sys_rw_content_t)
# para las carpetas donde PHP-FPM necesita modificar/crear archivos (storage, cache, imágenes).
sudo semanage fcontext -a -t httpd_sys_rw_content_t "$DIR_PROJECT/storage(/.*)?" 2>/dev/null || true
sudo semanage fcontext -a -t httpd_sys_rw_content_t "$DIR_PROJECT/bootstrap/cache(/.*)?" 2>/dev/null || true

# c) Aplicar las reglas definidas de SELinux al sistema de archivos
# Esto convierte las reglas permanentes ('semanage') en etiquetas activas.
sudo restorecon -R -v "$DIR_PROJECT"
echo "✅ SELinux: Reglas de contexto aplicadas correctamente."

# d) Activación de booleanos necesarios
# Permite a HTTPD leer el contenido de usuario (archivos de proyecto).
sudo setsebool -P httpd_read_user_content 1
# Permite a HTTPD conectarse a la red (para bases de datos, APIs externas, etc.).
sudo setsebool -P httpd_can_network_connect 1
echo "✅ SELinux: Booleanos httpd_read_user_content y httpd_can_network_connect activados."

# 9. 📝 Log (laravel.log)
# ----------------------------------------
if [ ! -f "$LOG_FILE" ]; then
  sudo -u $USER touch "$LOG_FILE"
  sudo chown $USER:$GROUP "$LOG_FILE"
  sudo chmod 664 "$LOG_FILE"
  echo "✅ laravel.log creado"
else
  echo "✅ laravel.log existe"
fi

# 10. 🔄 Apache
# ----------------------------------------
sudo systemctl reload httpd.service
echo "✅ Apache recargado"

echo "🎉 ¡CONFIGURACIÓN COMPLETADA! 🚀"
echo "💡 Siguiente paso: Ejecuta 'composer install' o 'composer update'."