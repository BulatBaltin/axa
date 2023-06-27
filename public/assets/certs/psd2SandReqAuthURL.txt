#!/bin/bash

###################################################################################
#                             REQUEST URL TO ING AUTHORIZATION APP                #
###################################################################################
# This script calls the endpoint "oauth2/authorization-server-url" to request     #
# an authorization code for requesting customer access token. In this script      #
# we pass "payment-account:balance:view" and "payment-accounts:transactions:view" #
# scope tokens to consume AIS API. You must request an application access token   #
# to run this script. Please update the variables "accessToken" and "certPath".   #
###################################################################################


keyId="5ca1ab1e-c0ca-c01a-cafe-154deadbea75" # client_id as provided in the documentation
certPath="./certs/" # path of the downloaded certificates and keys
httpHost="https://api.sandbox.ing.com"

# httpMethod must be in lower code
httpMethod="get"
reqPath="/oauth2/authorization-server-url?scope=payment-accounts%3Abalances%3Aview%20payment-accounts%3Atransactions%3Aview&redirect_uri=https://www.example.com&country_code=NL"

# Digest value for an empty body
digest="SHA-256=47DEQpj8HBSa+/TImW+5JCeuQeRkm5NMpJWZG3hSuFU="


# Generated value of the application access token. Please note that the access token expires in 15 minutes
accessToken="eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2Q0JDLUhTNTEyIiwia2lkIjoidHN0LTRjOGI1Mzk3LTFhYjgtNDFhOC1hNTViLWE3MTk5MTJiODNkMiIsImN0eSI6IkpXVCJ9..NtGrf2K9egtPUY1l1qS9Ug.N3-MOnw7cEyVX5E_GrFnv80MxegKDBKZa-zIPBu3RdsuhfnVf7mvMaMWBywGA8WzMXNcXmINP6lSNAoVGONtx7YUBQckjjcK4bN-BbquWPXRgB1WL9VOaaBTtq-hEbGWytIU28ccg3Ai8KezlllpFnLX6uCN1ZGKKxy3mFaJhJv-dMubZFT7ZpTqKIhTOYeAfhHUiPARxbArxzVZ5-Tp27_r-XUUHEqBhIga9eZZgT0aGYIHYVtFKvr2qmosBrwe7PU5qdYwG8962jlRJaXblUjbejO-a0MRlQGTDTEL-PZqWjcCRQ4qG0eDh4-M5EfNDGJIBXKZ4Mh32VUK-dYeB9K6i_cKzCy0xs9xOZbJvfBCQmsbujYTQ7VrInf_4UmZFK3-ASfN2J3AKGzuyx0bymTq3gueu0AiiHbzCMGyxfh09g-C8VKsXiMk8vdnIe4Yz1_GzhfrAuTNxcqbJyekgpJtsp5I8IOUGVe22IomfcIF2idH_9i5oJMiEeK-yoipMbkNtCUAAtBd2vfIL3ddm5UnVVoiaI7PRtppgYyMHLo6C3cLhBJNvGdgkGJxgdBTYb5Yudzwl0fomHQUMKziJagTFA4O3qGaE6_ImGq_wc_b-EhHajuF04jAU4yku9Oe08mzUXqPGzkxqPGl1l-WDBSwKMUg_JeG0Ms-LIX-4vFs6Oh5LA8LgIpTikT5SPG8gl8Enbz6n0Ja8Qu_3W3sezM7CETKkb1A_JICj6eVoT1ifGLa78njEqRIFGvbd5nj-cXSJHHOzQAVn00bsrg4gXqQuWnTn1dR_DQ2v1MRLfp9AYoGa8fz5I77hYsuPHhbUtfdETjUYOYJoFw-8Bhc3UgoEzn744a2BQPwZHWN2gE_WAVm_1eii2_EH8HDNgJm2BzWBgtvvokpJWJon5dJ7jXA0Zm8APApokvIidoDYnGpuTgnZSRMQ_t2yyl7nMXeF70MS_rdYTj2qtV1E192TzNzHLsM9zK0KyWcgsYlMxDeUQtTnIg0XAO3lANFYeymgJcT7lhJRCLgKxBTJHRrUl675wYXQZoWYIasaHXURGVyAjlwneAY66b1YIrz34sGsU1Wg7ufETufvwqCmrZw1EWq3oB2Tw59WLLo8Jrn7DSPAE85E2fr2uAPgmXzEoRhAgImqRyG31yOBmW9_6G5OKWqwyPjElu6CigZCi7LpPQZlSdtIi_UMvzqMXmXXgpn48Pr9QLLn8IocEZCEgkpL39zbGqEKDTvuwri_9_FaHW7jYNhHNwMc18SJECO5ZLxf0NixoFJO4WVN-YnMfLnXiGr3M-5q7YozUh8w9PW_9-QA8mZ2CCgc55gKNnDy_8myOqjdM-6cmIlLltwkJcdgRYG6qfCr8VfNZ0H6ywYiMOlKyJyYEOZ9daoge9_xmR-cgWpCcoSLiI1zq-Z5CmX37KbB3CUmyfuQ8E3D-zPsqyq-KuPJYfc4ScPq6by5PCKReWE2eUHTp4_Prv0desnzThQaHQe3gq_R1CIxIR5e2x3X21Ju7oyBBQ9iKEIomIdKP-o3FldCZ251hwwSi2O9fxmtxSNmf7UsYiIt4EUwhfrheB9JiO1v7ErmCH2YbB6PvzGjFpJwVp6JYIV_Vo3alSygOZsqvoVedQU8vE54Tn9ohNs2_RojscoweGEW74-ks2ou20u1tOt_PzkAmcoPdykSnkdAX4T-u1AX3ePZ2fAUFP39Z1EC2KJs6SGUN52HWqgIuvwe5mvahdhPH-ejHX0Uixs36yCvDEPaB-N-GY3QH-sFa5mnFcTdSwXCD3SsbW5oCahBPj0GiQEwjT7ESwqYav3r-A6g0xXQ8w_NURui32kocxsrS8bN4rumK9p3mpNVskbvuVWAAOJbGB0lBJTcAxjQmRzkptHrUX27LtFiaNDwjSaOYrRkVZiMIFQiZiC21B8MW4NjMr0MdhpFeOKOuqlhdVvxkbfp5zNgHfceUIyEI9y3pGcaCb0uCTSX95eUb7lx5dBv0_40iWEhDTihG-9CWnSbOyvTS1Xyq7bZQ8noslwPVM31mjjo-qi5DI7ZZbM52-0GjS1of6YFx0dRD3r4HDVVl7QDsPLtaUET7COYOn7ox1CGVxiNBMo0GFMm4EzRfDYN19Is_ZPWGrXk9G92G_i3Mg_tbT7fqXD3gNiKXaizKeNgHhrYjfRh0q38DLLEU8XP7odRI-1nKkHHeHAcOQhf-3pYqRUS7JxiWkycXczu7cFisyNZlooXkhn8oNunct3WAxzrqxCU8AZ4Nf3m_lFoPGH0Xs2I5EZVa98RTyVY_IFMr768kbp.1b0ltjr6kM29wtNh2bEzbOw1CdHxmP3zJc3-5J8FRhs"

reqDate=$(LC_TIME=en_US.UTF-8 date -u "+%a, %d %b %Y %H:%M:%S GMT")

# signingString must be declared exactly as shown below in separate lines
signingString="(request-target): $httpMethod $reqPath
date: $reqDate
digest: $digest"

signature=`printf %s "$signingString" | openssl dgst -sha256 -sign "${certPath}example_client_signing.key" | openssl base64 -A`

# Curl request method must be in uppercase e.g "POST", "GET"
curl -i -X GET "${httpHost}${reqPath}" \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-H "Digest: ${digest}" \
-H "Date: ${reqDate}" \
--user-agent "openbanking-get-started/1.0.0 bash" \
-H "Authorization: Bearer ${accessToken}" \
-H "Signature: keyId=\"$keyId\",algorithm=\"rsa-sha256\",headers=\"(request-target) date digest\",signature=\"$signature\"" \
-d "${payload}" \
--cert "${certPath}example_client_tls.cer" \
--key "${certPath}example_client_tls.key"
