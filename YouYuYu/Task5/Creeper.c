#include<stdio.h>
#include<string.h>
char GC(int *,int ,char []);
int main(void)
{
    int L,A,* B;
    char C[100],E[100];
    B=&A;
    printf("               \n"
           "  [][]    [][]  \n"
           "  [][]    [][]   \n"
           "      [][]       \n"
           "    [][][][]     \n"
           "    [][][][]      \n"
           "    []    []     \n"
           "               \n");
    printf("Are you ready?[Y/N]\n@Player1:");
    gets(E);
    if(E[0]=='N')
    {
        printf("@CPU0:OK,see you later.\n");
        return 0;
    }
    printf("@CPU0:\tCreeper?\n");
    for(A=1;A<75;A+=2)
    {
        printf("@Player:");
        gets(E);
        GC(B,A,E);
    }
    
    return 0;
}

char GC(int *B,int L,char E[])
{
    printf("@CPU0:\t");
    char *C[75]=
    {
        "Awww man!",
        "So we back in the mine",
        "Got our pickaxe swinging from side to side",
        "Side,side to side...",
        "This task's a grueling one , hope to find some diamonds tonight,night,night",
        "Diamonds tonight...",
        "Heads up",
        "You hear a sound , turn around and look up",
        "Total shock fills your body",
        "Oh no it's you again , I could never forget those eyes,eyes,eyes",
        "Eyes,eyes,eyes...",
        "Cause baby tonight",
        "the creeper's trying to steal all our stuff again",
        "Cause baby tonight",
        "you grab your pick shovel and bolt again",
        "bolt again-gain",
        "And run run until it's done done",
        "until the sun comes up in the morn",
        "Cause baby tonight",
        "the creeper's trying to steal all our stuff again",
        "stuff again-gain",
        "Just when you think you're safe",
        "overhear some hissing from right behind",
        "Right,right behind...",
        "That's a nice life you have",
        "shame it's gotta end at this time,time,time",
        "Time,time,time , time...",
        "Blows up",
        "then your health bar drops and you could use a one-up",
        "Get inside , don't be tardy",
        "So now you are stuck in there",
        "half a heart is left but don't die,die,die",
        "Die,die,die...",
        "Cause baby tonight",
        "the creeper's trying to steal all our stuff again",
        "Cause baby tonight",
        "you grab your pick , shovel and bolt again",
        "bolt again-gain",
        "And run,run until it's done,done",
        "until the sun comes up in the morn'",
        "Cause baby tonight ",
        "the creeper's trying to steal all our stuff again",
        "Creepers , you're mine , haha",
        "Dig up diamonds and craft those diamonds ",
        "and make some armour , get it baby",
        "Go and forge that like you so , MLG pro",
        "the sword's made of diamonds , so come at me bro Huh",
        "Training in your room under the torchlight",
        "hone that form to get you ready for the big fight",
        "Every single day and the whole night",
        "Creeper's out prowlin' , hmm - alright",
        "Look at me , look at you",
        "take my revenge that's what I'm gonna do",
        "I'm a - warrior baby , what else is new ?",
        "And my blade's gonna tear through you , bring it",
        "Cause baby tonight",
        "The creeper's trying to steal our stuff again",
        "Yeah , let's take back the world",
        "Yeah baby tonight Hahhah",
        "Grab your sword , armour and go. It's on",
        "Take your revenge (Woooo)",
        "Ahhoahh",
        "So fight,fight like it's the last,last night",
        "of your life,life show them your bite",
        "Wooo",
        "Cause baby tonight",
        "the creeper's trying to steal all our stuff again",
        "Cause baby tonight",
        "you grab your pick shovel and bolt again",
        "bolt again(gain) (wooo)",
        "And run,run until it's done,done",
        "until the sun comes up in the morn'",
        "Cause baby tonight",
        "the creeper's trying to steal all our stuff again",
        "Woooo"
    };
    if(strcmp(E,C[L-1])==0)
        puts(C[L]);
    else
    {
        printf("Try,again!\n"
                "@CPU0:\tCreeper?\n");
        *B=-1;
    }
}
