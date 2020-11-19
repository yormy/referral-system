      - name: Archive clover
        uses: actions/upload-artifact@v2
        with:
          name: code-coverage-report
          path: logs/clover.xml
