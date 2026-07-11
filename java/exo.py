#EXO 1 : Ecrire la fonction mult mettant en oeuvre la méthode de multiplication égyptienne.

def mult(n,a):
    if n == 1:
        print("cas de base", a)
        return a
    if n%2 == 0 :
        print(f" appel récursif à  {n//2}  fois {a*2}")
        return mult(n//2,a*2)
    else:
        print(f" appel récursif à  {n-1}  fois  {a}  plus  {a}")
        return a + mult(n-1,a)


#EXO 2 : Ecrire la fonction puiss mettant en oeuvre la méthode indienne de calcul des puissances .


def puiss(a,b):
    if b == 0:
        return 1
    if b%2 == 0:
        return puiss(a**2, b/2)
    else:
        return a * puiss(a, b-1)