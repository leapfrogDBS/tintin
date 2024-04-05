# ChangeMe

## Getting Started

1) In gulpfile.js, change theme folder from "wpbase-2022" to desired name

### Setup Composer
[Composer](https://getcomposer.org/) - Get Composer

the wp-config.php file uses dynamic variables. composer deals with this

Setup composer, then create an ".env" file in the "wp" folder, which contains the following, change the values to match the server:

```
DB_NAME="DBNAME"
DB_USER="USERNAME"
DB_PASSWORD="PASSWORD"
DB_HOST="localhost"
TABLE_PREFIX="db_wp_"
AUTH_KEY='i(HdlLERE7)+V>CNSoaE-cIW`:_%JgHS ]iC 2A}X Lw{91H}vk&j-m6%jt68_Bv)'
SECURE_AUTH_KEY='mBYt/J9nVA6-iy##X&vM 5mj)WPQT{GFK~VZv%vo[/-oK)_:&^Wjn9zc(M4G]]|8'
LOGGED_IN_KEY='SSR#zdAp1+-*Mu@,@Psxk+kyNrV^}12%)801B3{p74Ck;Ein1^ Df*#ae 44 Ls@'
NONCE_KEY='-er=LKU -d+66M+v+aw+k>TRYC{C0 mvlxl:hg@5PvoZs+ #JRmgWK]E1$FIt-NB'
AUTH_SALT='3yDa`gmZI603d135b#k3m~Z&Iix|qviPQ%vv6MQRc-[1y+nPm.d [&TCu7pRy!xW'
SECURE_AUTH_SALT='{6ZLB2#Zt`#LtS;-0qK(XcB= nza x#q ;Q+/4Y9/r-XCNMD<`%+JU6|ZpGW3fbI'
LOGGED_IN_SALT='2lCmMC1(I%&q?7kN(#fjj7o.>kpuCCJ|acXNN-p:$M(p9Mjq 3eNyR7+++gQlYAM'
NONCE_SALT='dL3c521B5ChT1=iA#TdObMx)+=XaC~[9o%6|O$*@eP43ILmp3R?]|G+P2V=p]_+:'
```

Then run "composer install" in "wp" directory

### Build
From the ROOT directory, run "npm install" then "npm start" whilst in development, or "npm run build" for final build

