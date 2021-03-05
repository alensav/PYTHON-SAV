#Словари
a = [234, 345]
d = {'test' :1}
print(d['test'])
#2-й способ записи словаря
b = dict (short='dict', longer='dictionery')
print (b)
#3-й способ - исключенияc 
c = dict.fromkeys(['a', 'b'])
#4-й способ
cd = {a : a**2 for a in range (9)}
print (c)
print(cd)