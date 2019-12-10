/***********************************************************
 * Script created by Elivelton C.
 * Desc: restart BIND abd Apache service
 ***********************************************************/

#include <stdio.h>
#include <stdlib.h>

int main() {
  if (!setuid(geteuid())) {
    system("/etc/init.d/named restart");
    system("apachectl graceful");
    system("/etc/init.d/nscd reload");
  } else {
    printf("Não possui SUID");
    return 1;
  }
  return 0;
}
