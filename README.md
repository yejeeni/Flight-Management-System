# Flight-Management-System
항공기 운항/예매 통합 시스템

## 프로젝트 소개
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/240811e8-4e5b-4ba8-8e7e-2382468eeddf)

고객/항공사/공항 세 사용자로 구성된 항공기 운항/예매 통합 시스템으로, 사용자 별 DB 이용 목적과 요구 조건에 적합한 데이터베이스를 개발하고 웹 사이트를 구성하였습니다.
  
## 개발 기간
- 2022.9. - 2022.11.

### 업무분장
- 팀원 김예진, 김민진, 우새빛, 정혜은

### 개발환경
- 개발언어: MySQL, HTML, PHP

## 주요 기술
**1) Database**<br>
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/13030348-1bae-40f1-8187-d4f6a087b2f2)

사용자 별 DB 이용 목적을 정리하고 정의한 요구조건에 알맞은 DB를 MySQL을 이용하여 설계하였다. <br>

**2) Web**<br>
HTML과 PHP를 이용하여 웹사이트를 제작하였다.<br>

최초 메인 페이지는 고객 예매 페이지, 항공사 메인 페이지, 공항 메인 페이지로 나뉘어있으며 고객/항공사의 경우 아이디와 비밀번호로 로그인한다. 공항의 경우 사전에 등록된 보안코드를 입력하여 페이지에 접근할 수 있다.<br>

- 사용자
1. 항공기 예매
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/df1bfc32-a904-442a-a869-fa1eae44ad3f)

출발지, 도착지, 탑승 날짜, 좌석 등급을 선택하여 빈 좌석이 존재하는 항공기를 조회할 수 있다. 원하는 항공편의 운행 번호를 선택하여 여행 정보 입력 및 구매 페이지로 이동할 수 있다. 개인정보와 할인을 위한 우대조건(소아/경로우대/군인 등), 원하는 빈 좌석을 선택하면 결제 금액이 계산되며 예매할 수 있다. 생성된 예매정보는 조회할 수 있다.<br>

예매가 성공하면 생성되는 예매 번호를 운행 별 좌석 정보에 업데이트한다. 모든 좌석마다 예매 번호가 부여된다면 매진으로 판단하고, 매진 날짜를 업데이트한다.<br>

- 항공사
1. 비행기 운행 정보 등록
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/71b0a2f9-4b26-47ea-a6a7-365d7d43b83d)

비행기번호, 출발/도착지, 출발/도착 시간, 체크인/착륙 시간을 입력하여 운행 정보를 등록할 수 있다. 등록 시 DB에 저장된 과거 데이터를 통해 등록한 운행의 예상 탑승자 비율이나 예상 매진 소요일을 확인할 수 있다. 비행기번호, 출발/도착지, 출발/도착 시간으로 운행 정보를 조회하고 운행 번호를 선택하여 등록한 정보를 수정하는 것도 가능하다.<br>

운행 정보가 등록되면 생성되는 운행 번호와 비행기의 좌석 정보를 불러와 모든 좌석을 예매가 가능한 빈 좌석으로 등록한다. <br>

2. 예매자 조회<br>
운행 번호와 예매 번호를 통해 예매자를 조회할 수 있다.<br>

3. 직원 배치 및 수정<br>
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/83216075-7cbb-4ee5-a74d-8e534664d5d7)

입력한 운행 번호 정보를 통해 운행 번호 결과, 배정된 직원, 재직 중인 직원을 조회한다. 사원 번호를 입력하여 직원을 추가로 배정하거나 삭제할 수 있다.<br>

5. 운행 통계<br>
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/60e68e11-52b7-4df8-951a-1a3cc9125675)

월별, 노선별 탑승자 수 통계를 확인할 수 있다. 예매 번호의 개수를 카운팅하여 운행 번호별 탑승자 수 정보를 가지고 있는 임시 테이블을 생성하고, 이를 운행 정보 테이블과 조인하여 한다. 월별 탑승자 수 계산 시 운행 번호, 운행 시작 날짜, 탑승자 수 정보가 있는 임시테이블을 생성하고, 노선별 탑승자 수 계산 시 운행 번호, 출발/도착지, 탑승자 수 정보가 있는 임시 테이블을 생성하여 노선 별 탑승자 수 합을 계산한다. <br>

- 공항<br>
1. 비행기 조회
![image](https://github.com/yejeeni/Flight-Management-System/assets/110469361/2f6f2e89-4f15-401a-a3a6-ed3ca6e7a22d)

항공사에서 등록한 운행 정보를 조회하고 탑승구와 상태(지연 시간)를 업데이트할 수 있다.<br>

2. 탑승자 조회<br>
운행번호, 예매번호를 통해 탑승자를 조회하고 삭제할 수 있다.<br>

## 달성 성과
- **데이터베이스 설계에 대한 이해**: 사용자의 요구를 분석하고 데이터베이스 구조로 변형하여 DBMS로 구현할 수 있다.
- **SQL문에 대한 이해**: DDL, DML, DCL에 대해 공부하고 원하는 결과를 위한 SQL문을 작성할 수 있다.
