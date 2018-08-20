#!/bin/bash

branch_name=$(git symbolic-ref -q HEAD)
branch_name=${branch_name##refs/heads/}
branch_name=${branch_name:-HEAD}

VERSION=$(cat ./.version)

## run cmd with '--dry-run'
if [ "$1" == "--dry-run" ]; then
    function git {
        echo "{CMD} git $@"
    }
fi

function doRelease {
    local_version=$1
    git tag -a v${local_version} -m "Release v${local_version}"
    git push --all

    local_version=$(( local_version+1 ))

    printf ${local_version} > ./.version

    git commit -am "Increased Version for next release cycle"
}


if [ "${branch_name}" == "master" ]; then
    doRelease ${VERSION}
else
    git checkout master
    git merge ${branch_name}

    git push --all

    doRelease ${VERSION}

    git checkout ${branch_name}
    git merge master

    git push --all
fi