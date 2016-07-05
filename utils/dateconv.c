#include <stdio.h>

int main(int argc, char ** argv)
{
/*    FILE * handle = fopen(0, "r");*/
    int year;
    int month;
    int day;
    int hour;
    int minute;
    int second;
    sscanf(argv[1], " %d:%d:%d %d:%d:%d", &year, &month, &day, &hour, &minute, &second);
    printf("%04d-%02d-%02d %02d:%02d:%02d\n", year, month, day, hour, minute, second);
/*    fclose(handle);*/
}

