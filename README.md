install front deps:  
```
docker run -it --rm -v "$PWD":/app -w /app node yarn install
```

using yarn for build front:  
```
docker run -it --rm -v "$PWD":/app -w /app node yarn run encore dev
docker run -it --rm -v "$PWD":/app -w /app node yarn run encore dev --watch
docker run -it --rm -v "$PWD":/app -w /app node yarn run encore production
 ```
