l = []
lis = [1,56,'x',34,2.34,['s', 'o']]
print(lis)
a = [a + b for a in 'list' if a != 's' for b in 'soup' if b != 'u"]']
print(a)
b = [24,64]
l.append(23)
l.append(34)
l.extend(b)
l.insert(1, 56)
l.remove(34)
l.pop(0)
l.sort()
l.reverse()
print(l.index(64))
print(l.count(56))
print("список l", l)